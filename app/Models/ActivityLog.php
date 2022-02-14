<?php

namespace App\Models;

use App\Models\City\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'activity_logs';
    protected $with = 'user';
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }
    #endregion relationships


    #region custom Methods
    public function setNewDataAttribute($value)
    {
        $value ? $this->attributes['new_data'] = json_encode($value) : null;
    }

    public function setOldDataAttribute($value)
    {
        $value ? $this->attributes['old_data'] = json_encode($value) : null;
    }

    // Function for adding user activity log
    public static function addUserActivity($item)
    {
        $activity = [];
        $activity['auditable_id'] = $item->id;
        $activity['auditable_type'] = get_class($item);
        $activity['url'] = Request::fullUrl();
        $activity['old_data'] = $item->getOriginal() ? array_except($item->getOriginal(), ['created_at', 'updated_at', 'deleted_at']) : $item;
        $activity['new_data'] = array_except($item->getChanges(), ['created_at', 'updated_at', 'deleted_at']) ?? null;
        $activity['action_type'] = Request::method();
        $activity['ip_address'] = Request::ip();
        $activity['agent'] = Request::header('user-agent');
        $activity['user_id'] = auth()->check() ? auth()->user()->id : null;
        static::create($activity);
    }
    #endregion custom Methods

}
