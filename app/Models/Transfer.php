<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Uuid;
use App\Traits\Loggable;
use GeniusTS\HijriDate\Hijri;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TransferPurpose\TransferPurpose;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transfer extends Model
{
    use HasFactory, Uuid, Loggable, SoftDeletes;
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    #region properties
    // Wallet Transfer Methods
    const PHONE = 'phone';
    const IDENTITY_NUMBER = 'identity_number';
    const WALLET_NUMBER = 'wallet_number';

    // transfer_status
    const CANCELED = 'canceled';
    const PENDING = 'pending';
    const ARCHIVED = 'archived';
    const TRANSFERRED = 'transferred';
    const STATUSES = [self::CANCELED, self::PENDING, self::ARCHIVED, self::TRANSFERRED];

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
    public function getCreatedAtDateMobileAttribute($date)
    {
        $locale = app()->getLocale();
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale($locale);
            return Hijri::convertToHijri($this->attributes['created_at'])->format('d F o');
        }
        return Carbon::parse($this->attributes['created_at'])->locale($locale)->translatedFormat('j F Y');
    }

     public function getCreatedAtTimeMobileAttribute($date)
    {
        $locale = app()->getLocale();
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale($locale);
            return Hijri::convertToHijri($this->attributes['created_at'])->format('h:i A');
        }
        return Carbon::parse($this->attributes['created_at'])->locale($locale)->translatedFormat('h:i A');
    }

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
        return $this->hasOneThrough(Beneficiary::class,BankTransfer::class,'transfer_id','id','id','beneficiary_id');
    }

    public function fromUser()
    {
      return $this->belongsTo(User::class,'from_user_id');
    }

    public function toUser()
    {
      return $this->belongsTo(User::class,'to_user_id');
    }

    public function transferPurpose(): BelongsTo
    {
        return $this->belongsTo(TransferPurpose::class, 'transfer_purpose_id');
    }
    #endregion relationships

    #region custom Methods


    #endregion custom Methods
}
