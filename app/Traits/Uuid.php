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
        $image = $this->images()->first()?->media;

        if ($image == null && !request()->has('with_activity') && !request()->routeIs('dashboard.*')) {
            return asset('dashboardAssets/images/brand/no-img.png');
        } elseif ($image == null && request()->routeIs('dashboard.*.edit')) {
            return null;
        } elseif ($image == null) {
            return asset('dashboardAssets/images/brand/no-img.png');
        } else {
            return asset($image);
        }
    }

    public function getCreatedAtAttribute($date)
    {
        $locale = app()->getLocale();
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale($locale);
            return Hijri::convertToHijri($date)->format('d F o');
        }
        return Carbon::parse($date)->locale($locale)->translatedFormat('j F Y');
    }

    public function getUpdatedAtAttribute($date)
    {
        $locale = app()->getLocale();
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale($locale);
            return Hijri::convertToHijri($date)->format('d F o');
        }
        return Carbon::parse($date)->locale($locale)->translatedFormat('j F Y');
    }

    public function getDeletedAtAttribute($date)
    {
        $locale = app()->getLocale();
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale($locale);
            return Hijri::convertToHijri($date)->format('d F o');
        }
        return Carbon::parse($date)->locale($locale)->translatedFormat('j F Y');
    }

    public function changeDateLocale($locale = 'ar')
    {
        if ($locale == 'en') {
            Date::setTranslation(new English);
            Date::setDefaultNumbers(Date::ARABIC_NUMBERS);
        } else {
            Date::setTranslation(new Arabic);
            Date::setDefaultNumbers(Date::INDIAN_NUMBERS);
        }
    }
}
