<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
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
    public function bank_transfer()
    {
        return $this->hasOne(BankTransfer::class,'transfer_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
