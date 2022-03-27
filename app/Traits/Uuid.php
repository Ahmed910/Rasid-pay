<?php

namespace App\Traits;

use App\Scopes\GlobalSearchScope;
use GeniusTS\HijriDate\{Date, Hijri, Translations\Arabic, Translations\English};
use Illuminate\Support\Str;
use Carbon\Carbon;

trait Uuid
{
    /**
     * Boot function from Laravel.
     */
    protected static function bootUuid()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function getImageAttribute()
    {
        if ($this->images()->first()?->media == null && !request()->has('with_activity') && !request()->routeIs('dashboard.*')) return asset('dashboardAssets/images/brand/logo-3.png');

        return asset($this->images()->first()?->media);
    }

    public function getCreatedAtAttribute($date)
    {
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale(app()->getLocale());
            return Hijri::convertToHijri($date)->format('d F o');
        }
        return Carbon::parse($date)->format("Y F d");
    }

    public function getUpdatedAtAttribute($date)
    {
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale(app()->getLocale());
            return Hijri::convertToHijri($date)->format('d F o');
        }
        return Carbon::parse($date)->format("Y F d");
    }

    public function getDeletedAtAttribute($date)
    {
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale(app()->getLocale());
            return Hijri::convertToHijri($date)->format('d F o');
        }
        return Carbon::parse($date)->format("Y F d");
    }

    public function changeDateLocale($locale = 'ar')
    {
        if ($locale == 'en') {
            Date::setTranslation(new English);
            Date::setDefaultNumbers(Date::ARABIC_NUMBERS);
            Carbon::setLocale("en");
        } else {
            Date::setTranslation(new Arabic);
            Date::setDefaultNumbers(Date::INDIAN_NUMBERS);
            Carbon::setLocale("ar");
        }
    }
}
