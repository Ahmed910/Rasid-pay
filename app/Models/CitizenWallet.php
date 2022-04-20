<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class CitizenWallet extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];
    #endregion properties
    public function setWalletNumberAttribute($value)
    {
        if (!isset($this->attributes['wallet_number'])) {
            $this->attributes['wallet_number'] = $value;
            $this->attributes['wallet_qr'] = $this->createQr($value);
        }elseif (isset($this->attributes['wallet_number']) && $this->attributes['wallet_number'] != $value) {
            $this->attributes['wallet_number'] = $value;
            $this->attributes['wallet_qr'] = $this->createQr($value);
        }
    }

    public function getQrcodeAttribute()
    {
        return asset('storage/'.$this->attributes['wallet_qr']);
    }
    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods

    private function createQr($qr_value)
    {
        $this->checkOrCreateQrDirectory();
        $filname = time()."_".$qr_value."_qr_code.png";
        $path = storage_path('app/public/images/citizen_wallet/'.$filname);
        \QrCode::errorCorrection('H')
                ->format('png')
                ->encoding('UTF-8')
                ->merge(public_path('assets/images/logoQR.png'), .2 ,true)
                ->size(500)
                ->generate($qr_value, $path);
        return 'images/citizen_wallet/' . $filname;
    }

    private function checkOrCreateQrDirectory()
    {
        if (!\File::isDirectory(storage_path('app/public/images/citizen_wallet/'))){
            \File::makeDirectory(storage_path('app/public'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'citizen_wallet'.DIRECTORY_SEPARATOR), 0777, true);
        }
    }
}
