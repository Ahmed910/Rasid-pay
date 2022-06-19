<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use HasFactory, Uuid, Loggable, SoftDeletes;
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    #region properties
    // Wallet Transfer Methods
    const PHONE = 'phone';
    const IDENTITY_NUMBER = 'identity_number';
    const WALLET_NUMBER = 'wallet_number';

    const WALLET_TRANSFER_METHODS = [self::PHONE, self::IDENTITY_NUMBER, self::WALLET_NUMBER];
    // Transfer Types
    const WALLET = 'wallet';
    const LOCAL = 'local';
    const GLOBA = 'global';
    const TRANSFER_TYPES = [self::WALLET, self::LOCAL, self::GLOBA];
    // Fee Upon
    const FROM_USER = 'from_user';
    const TO_USER = 'to_user';
    const FEE_UPON = [self::FROM_USER, self::TO_USER];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function transaction()
    {
        return $this->morphOne(Transaction::class, "transactionable");
    }

    public function bankTransfer()
    {
        return $this->hasOne(BankTransfer::class, 'transfer_id');
    }

    public function beneficiary()
    {
        return $this->hasOneThrough(Beneficiary::class,bankTransfer::class,'transfer_id','id','id','beneficiary_id');
    }

    public function fromUser()
    {
      return $this->belongsTo(User::class,'from_user_id');
    }

    public function toUser()
    {
      return $this->belongsTo(User::class,'to_user_id');
    }
    #endregion relationships

    #region custom Methods


    #endregion custom Methods
}
