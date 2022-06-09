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
    // Wallet Transfer Methods
   private const PHONE = 'phone';
   private const IDENTITY_NUMBER = 'identity_number';
   private const WALLET_NUMBER = 'wallet_number';

   const WALLET_TRANSFER_METHODS = [self::PHONE,self::IDENTITY_NUMBER,self::WALLET_NUMBER];
   // Transfer Types
   private const WALLET = 'wallet';
   private const LOCAL = 'local';
   private const GLOBA = 'global';
   const TRANSFER_TYPES = [self::WALLET,self::LOCAL,self::GLOBA];
   // Fee Upon
   private const FROM_USER = 'from_user';
   private const TO_USER = 'to_user';
   const FEE_UPON = [self::FROM_USER,self::TO_USER];
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
    
    public function bank_transfer()
    {
        return $this->hasOne(BankTransfer::class,'transfer_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
