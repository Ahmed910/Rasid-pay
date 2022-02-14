<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{

    public function getReadAtAttribute($date)
    {
        return $date ? date('Y-m-d h:i a', strtotime($date)) : null;
    }

    public function getCreatedAtAttribute($date)
    {
        return date('Y-m-d h:i a', strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return date('Y-m-d h:i a', strtotime($date));
    }
}
