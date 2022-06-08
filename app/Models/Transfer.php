<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Transfer extends Model
{
    use HasFactory, Uuid;

    #region properties
    const FROM_USER = 'from_user';
    const TO_USER = 'to_user';

    const WHO_BUY_FEES = [
        self::FROM_USER,
        self::TO_USER
    ];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
