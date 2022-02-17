<?php

namespace App\Models;

use App\Traits\Uuid;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use Uuid;

    protected $guarded = ['created_at', 'updated_at'];
}
