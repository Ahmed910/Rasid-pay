<?php

namespace App\Traits;

use App\Models\ActivityLog;
use App\Models\Contact;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

trait Loggable
{
    protected static function bootLoggable()
    {
        static::created(function (self $self) {
            $self->addUserActivity($self, ActivityLog::CREATE, 'create');
        });

        static::updated(function (self $self) {
            if ($self->isDirty('deleted_at')) {
                if (in_array(SoftDeletes::class, class_uses(static::class))) {
                    static::restored(function (self $self) {
                        return $self->addUserActivity($self, ActivityLog::RESTORE, 'archive');
                    });
                }
            } else {
                if (in_array(class_basename($self), ['User', 'Admin']))
                    return $self->checkIfHasIsActiveOnly($self, 'ban_status');

                if (in_array(class_basename($self), ['Contact'])) {
                    if (request('assigned_to_id')) return;
                    return $self->checkIfHasIsActiveOnly($self, 'message_status');
                }

                $self->checkIfHasIsActiveOnly($self, 'is_active');
            }
        });

        static::deleted(function (self $self) {
            if ($self->forceDeleting)
                $self->addUserActivity($self, ActivityLog::PERMANENT_DELETE, 'archive');

            $self->addUserActivity($self, ActivityLog::DESTROY, 'index');
        });
    }

    public function activity()
    {
        return $this->morphMany(ActivityLog::class, 'auditable')->withTrashed();
    }

    /**
     * Add new Record in Activity Log
     *
     * @param Illuminate\Database\Eloquent\Model $item
     * @param string $event
     *
     * @return void
     */
    public function addUserActivity($item, string $event, string $subProgram, array $newData = [])
    {
        $user_type = $item->user_type ?? null;
        if (isset($item->user) && $user_type == null) $user_type = $item->user->user_type;
        $item->activity()->create([
            'url'         => Request::fullUrl(),
            'old_data'    => $this->oldData($item),
            'new_data'    => $newData ? $newData : $this->newData($item),
            'action_type' => $event,
            'sub_program' => $subProgram,
            'ip_address'  => Request::ip(),
            'agent'       => Request::header('user-agent'),
            'user_id'     => auth()->check() ? auth()->user()->id : null,
            'reason'      => request()->reasonAction,
            "user_type"   => $user_type
        ]);
    }


    /**
     * Add New Record Global in Activity Log
     *
     * @param $this
     * @param array $logs
     * @param string $event
     *
     * @return void
     */
    public function addGlobalActivity($item, array $logs, string $event, string $subProgram, string $user_type = null)
    {
        $logs = array_except($logs, ['per_page', 'page']);
        if (!count($logs)) return;
        $activity = [];
        $activity['auditable_type'] = class_basename($item);
        $activity['url'] = Request::fullUrl();
        $activity['action_type'] = $event;
        $activity['sub_program'] = $subProgram;
        $activity['ip_address'] = Request::ip();
        $activity['agent'] = Request::header('user-agent');
        $activity['user_id'] = auth()->check() ? auth()->user()->id : null;
        $activity['search_params'] = $logs;
        $activity['user_type'] = $user_type;

        ActivityLog::create($activity);
    }

    /**
     * get new Data
     */
    private function newData($item)
    {
        $data['permissions'] = !is_array(@$item->permissions) ? ($item->permissions?->map->name->toArray() ?? []) : [];
        $data['groups'] = $item->groups?->map->name->toArray() ?? [];
        $data['translations'] = $item->translations?->map->getDirty()->toArray();

        $newData = array_except($item->getChanges(), ['created_at', 'deleted_at']);
        if (request()->has('image') && request()->route()->getActionMethod() == 'update') {
            $newData += ['image' => $item->images->pluck('media')->toJson()];
        }
        return array_merge($newData, array_filter($data));
    }

    /**
     * get old Data
     */
    private function oldData($item)
    {
        if (!$item->getOriginal()) return $item;

        $data['permissions'] = $item->permissions?->map->name->toArray() ?? [];
        $data['groups'] = $item->groups?->map->name->toArray() ?? [];
        $data['translations'] = $item->translations?->map->getOriginal()->toArray();
        $originalData = array_except($item->getOriginal(), ['created_at', 'updated_at', 'deleted_at']);

        return array_merge($originalData, array_filter($data));
    }

    private function checkStatus(self $model, string $column)
    {
        $table = $model->getTable();

        if ((Schema::hasColumn($table, $column) && request()->has($column)) || (Schema::hasColumn($table, $column) && $column == 'message_status')) {
            if (request($column) != $model->getOriginal()[$column]) {
                $newData = array_only($this->newData($model), [$column, 'ban_from', 'ban_to']);

                if (request($column) && $column == 'is_active') {
                    $model->addUserActivity($model, ActivityLog::ACTIVE, 'index', $newData);
                }

                if (!request($column) && $column == 'is_active') {
                    $model->addUserActivity($model, ActivityLog::DEACTIVE, 'index', $newData);
                }

                if (request($column) == 'permanent' && $column == 'ban_status') {
                    $model->addUserActivity($model, ActivityLog::PERMANENT, 'index', $newData);
                }

                if (request($column)  == 'temporary' && $column == 'ban_status') {
                    $model->addUserActivity($model, ActivityLog::TEMPORARY, 'index', $newData);
                }

                if (request($column) == 'active' && $column == 'ban_status') {
                    $model->addUserActivity($model, ActivityLog::ACTIVE, 'index', $newData);
                }

                if ($model->$column == Contact::WAITING && $column == 'message_status') {
                    $model->addUserActivity($model, ActivityLog::SHOWN, 'index', $newData);
                }

                if ($model->$column == ActivityLog::REPLIED && $column == 'message_status') {
                    $model->addUserActivity($model, ActivityLog::REPLIED, 'index', $newData);
                }
            }
        }
    }

    private function checkIfHasIsActiveOnly($self, string $column)
    {

        // user => ban_status (only ban status)
        // rest of models => is_active (only is_active)
        $exceptedColumns =  [
            $column,
            'groups',
            'permissions',
            'ban_from',
            'ban_to',
            'user_locale',
            'updated_at',
            'read_at',
        ];

        $keys = array_keys($this->newData($self));
        $hasData = count(array_flatten(array_except($this->newData($self), $exceptedColumns)));
        if (
            !$hasData
            && !request()->has('image')
            && in_array($column, $keys)
        ) {
            if (in_array(HasAssetsTrait::class, class_uses(static::class))) {
                if (!request()->image_deleted) {
                    $this->checkStatus($self, $column);
                } else {
                    $self->addUserActivity($self, ActivityLog::UPDATE, 'index');
                }
            }
        } elseif ($hasData && in_array($column, $keys)) {
            $self->addUserActivity($self, ActivityLog::UPDATE, 'index');
        } else {
            $self->addUserActivity($self, ActivityLog::UPDATE, 'index');
        }
    }
}
