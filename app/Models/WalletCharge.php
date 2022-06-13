<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class WalletCharge extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $table = 'wallet_charges';
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['last_updated_at'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    #endregion relationships

    #region custom Methods
    public function transaction()
    {
        return $this->morphOne(Transaction::class, "transactionable");
    }
    #endregion custom Methods
}
