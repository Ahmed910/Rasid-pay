<?php

namespace App\Models;
use App\Traits\{Loggable,Uuid};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankTransfer extends Model
{
    use HasFactory, Uuid, Loggable, SoftDeletes;
    protected $guarded = ['created_at','updated_at', 'deleted_at'];

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
