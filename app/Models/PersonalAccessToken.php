<?php

namespace App\Models;

use App\Traits\Loggable;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use Loggable;

    protected $guarded = ['created_at', 'updated_at'];
}
