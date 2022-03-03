<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

trait Loggable
{
    protected static function bootLoggable()
    {
        static::created(function (self $self) {
            $self->addUserActivity($self, "created");
        });

        static::updated(function (self $self) {
            $self->addUserActivity($self, "updated");
        });

        static::deleted(function (self $self) {
            if ($self->forceDeleting) {
                $self->addUserActivity($self, "permanent_delete");
            }

            if (!$self->forceDeleting) {
                $self->addUserActivity($self, "destroy");
            }
        });

        if (in_array(SoftDeletes::class, class_uses(static::class))) {
            static::restored(function (self $self) {
                $self->addUserActivity($self, "restored");
            });
        }
    }

    public function activity()
    {
        return $this->morphMany(ActivityLog::class, 'auditable');
    }

    /**
     * Add new Record in Activity Log
     *
     * @param Illuminate\Database\Eloquent\Model $item
     * @param string $event
     *
     * @return void
     */
    private function addUserActivity($item, string $event)
    {
        $activity = [];
        $activity['auditable_id'] = $item->id;
        $activity['auditable_type'] = get_class($item);
        $activity['url'] = Request::fullUrl();
        $activity['old_data'] = $this->oldData($item);
        $activity['new_data'] = $this->newData($item);
        $activity['action_type'] = $event;
        $activity['ip_address'] = Request::ip();
        $activity['agent'] = Request::header('user-agent');
        $activity['user_id'] = auth()->check() ? auth()->user()->id : null;
        $activity['reason'] = request()->reasonAction;
        ActivityLog::create($activity);
    }

    /**
     * get new Data
     */
    private function newData($item)
    {
        if (!$item->getChanges()) return null;

        $translations = $item->translations?->map->getDirty()->toArray();
        $newData = array_except($item->getChanges(), ['created_at', 'updated_at', 'deleted_at']);

        return array_merge($newData ?? [], $translations ?? []);
    }

    /**
     * get old Data
     */
    private function oldData($item)
    {
        if (!$item->getOriginal()) return $item;

        $translations = $item->translations?->map->getOriginal()->toArray();
        $originalData = array_except($item->getOriginal(), ['created_at', 'updated_at', 'deleted_at']);

        return array_merge($originalData ?? [], $translations ?? []);
    }
}
