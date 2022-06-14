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

    public function bank_transfer()
    {
        return $this->hasOne(BankTransfer::class, 'transfer_id');
    }
    #endregion relationships

    #region custom Methods
    public function get_wallet_receiver($method, $val)
    {
        if (!in_array($method, self::WALLET_TRANSFER_METHODS)) return null;
        $receiver = $method == "wallet_number" ? CitizenWallet::where("wallet_number", $val)->select("id", "citizen_id")->with("citizen:id,in_black_list")->firstorfail()
            : User::where($method, $val)->where("user_type", "citizen")->select("id")->with("citizenWallet")->first()?->citizenWallet;
        return $receiver;
    }

    #endregion custom Methods
}
