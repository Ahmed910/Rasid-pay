<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Models\ActivityLog;

trait Uuid
{
    /**
     * Boot function from Laravel.
     */
    protected static function booted()
    {
        parent::boot();

        static::created(function ($item) {
            ActivityLog::addUserActivity($item);
        });

        static::updated(function ($item) {
            ActivityLog::addUserActivity($item);
        });

        static::deleted(function ($item) {
            ActivityLog::addUserActivity($item);
        });

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function getCreatedAtAttribute($date)
    {
        return date('Y-m-d h:i A', strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return date('Y-m-d h:i A', strtotime($date));
    }

    public function getDeletedAtAttribute($date)
    {
        return date('Y-m-d h:i A', strtotime($date));
    }

    public function activity()
    {
        return $this->morphMany(ActivityLog::class, 'auditable');
    }


}
