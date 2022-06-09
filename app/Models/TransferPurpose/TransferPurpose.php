<?php

namespace App\Models\TransferPurpose;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use App\Models\BankTransfer;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferPurpose extends Model
{
    use HasFactory, SoftDeletes, Uuid, Translatable, Loggable;

    #region properties
    public $translatedAttributes = ['name','description'];
    protected $guarded = ['created_at','updated_at','deleted_at'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function bankTransfer()
    {
        return $this->hasMany(BankTransfer::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
