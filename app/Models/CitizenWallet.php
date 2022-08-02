<?php

namespace App\Models;

use App\Services\GenerateQrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class CitizenWallet extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['last_updated_at'];
    #endregion properties
    public function setWalletNumberAttribute($value)
    {
        if (!isset($this->attributes['wallet_number'])) {
            $this->attributes['wallet_number'] = $value;
            $this->attributes['wallet_qr'] = GenerateQrCode::createQr($value, 'app/public/images/citizen_wallet/');
        } elseif (isset($this->attributes['wallet_number']) && $this->attributes['wallet_number'] != $value) {
            $this->attributes['wallet_number'] = $value;
            $this->attributes['wallet_qr'] = GenerateQrCode::createQr($value, 'app/public/images/citizen_wallet/');
        }
    }

    public function getQrCodeAttribute()
    {
        return asset('storage/' . $this->attributes['wallet_qr']);
    }
    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function citizen()
    {
        return $this->belongsTo(User::class, 'citizen_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
