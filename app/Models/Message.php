<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Message extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = ['last_messgae' => 'datetime', 'read_at' => 'datetime'];


    #region properties
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
