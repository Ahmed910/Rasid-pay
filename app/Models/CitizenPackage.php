<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Uuid;
use GeniusTS\HijriDate\Hijri;
use App\Models\Package\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use phpDocumentor\Reflection\DocBlock\Tags\Deprecated;

class CitizenPackage extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['start_at', 'end_at'];
    const BASIC = 'basic';
    const GOLDEN = 'golden';
    const PLATINUM = 'platinum';
    const PACKAGE_TYPES = [self::BASIC, self::GOLDEN, self::PLATINUM];

    #endregion properties

    #region mutators
    #endregion mutators
    public function getStartAtAttribute($date)
    {
        $locale = app()->getLocale();
        if (auth()->check() && auth()->user()->is_date_hijri) {
            Uuid::changeDateLocale($locale);
            return Hijri::convertToHijri($date)->format('d F o');
        }

        return $date;
        // return Carbon::parse($date)->locale($locale)->translatedFormat('j F Y');
    }

    public function getEndAtAttribute($date)
    {
        $locale = app()->getLocale();
        if (auth()->check() && auth()->user()->is_date_hijri) {
            Uuid::changeDateLocale($locale);
            return Hijri::convertToHijri($date)->format('d F o');
        }
        return $date;
        // return Carbon::parse($date)->locale($locale)->translatedFormat('j F Y');
    }

    public function getEndAtDashboardAttribute()
    {
        $locale = app()->getLocale();
        if (auth()->check() && auth()->user()->is_date_hijri) {
            Uuid::changeDateLocale($locale);
            return Hijri::convertToHijri($this->attributes['end_at'])->format('d F o');
        }

        return Carbon::parse($this->attributes['end_at'])->locale($locale)->translatedFormat('j F Y');
    }

    public function getStartAtDashboardAttribute()
    {
        $locale = app()->getLocale();
        if (auth()->check() && auth()->user()->is_date_hijri) {
            Uuid::changeDateLocale($locale);
            return Hijri::convertToHijri($this->attributes['end_at'])->format('d F o');
        }

        return Carbon::parse($this->attributes['end_at'])->locale($locale)->translatedFormat('j F Y');
    }

    #region scopes
    public function setPackageIdAttribute($value)
    {
        $this->attributes['package_id'] = $value;
        // $this->attributes['card_data'] = Package::select('id','price','offer','cash_back','promo_cash_back','discount_promo_code')->listsTranslations('name')->find($value)->toJson();

    }
    #endregion scopes

    #region relationships

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function citizen()
    {
        return $this->belongsTo(User::class, 'citizen_id');
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, "transactionable");
    }

    public function citizenPackagePromoCodes()
    {
        return $this->hasMany(CitizenPackagePromoCode::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
