<?php

namespace App\Models\TransferPurpose;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class TransferPurposeTranslation extends Model
{
    use HasFactory, Uuid;

    public $timestamps = false;
    protected $guarded = ['created_at', 'updated_at'];

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
