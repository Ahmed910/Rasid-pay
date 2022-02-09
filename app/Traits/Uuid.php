<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;

trait Uuid
{
    /**
     * Boot function from Laravel.
     */
    protected static function booted()
    {
        parent::boot();
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
        return date('Y-m-d h:i a', strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return date('Y-m-d h:i a', strtotime($date));
    }

    public function getDeletedAtAttribute($date)
    {
        return date('Y-m-d h:i a', strtotime($date));
    }
}
