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
    public function saveQuietly(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {

            if (empty($this->{$this->getKeyName()})) {
                $this->{$this->getKeyName()} = (string)Str::uuid();
            }
            return $this->save($options);
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

    public function getCreatedAtDateAttribute($date)
    {
        if ($date==null) return $date ;
        $locale = app()->getLocale();
        // if (auth()->check() && auth()->user()->is_date_hijri) {
        if ((bool)setting('rasid_date_type')) {
            $this->changeDateLocale($locale);
            return Hijri::convertToHijri($this->created_at)->format('d F o');
        }
        return Carbon::parse($this->created_at)->locale($locale)->translatedFormat('j F Y');
    }

    public function getCreatedAtDateTimeAttribute($date)
    {
        if ($date==null) return $date ;
        $locale = app()->getLocale();
        // if (auth()->check() && auth()->user()->is_date_hijri) {
        if ((bool)setting('rasid_date_type')) {
            $this->changeDateLocale($locale);
            return Hijri::convertToHijri($this->created_at)->format('d F o - h:i A');
        }
        return Carbon::parse($this->created_at)->locale($locale)->translatedFormat('j F Y - h:i A');
    }

    public function getUpdatedAtDateAttribute($date)
    {
        if ($date==null) return $date ;
        $locale = app()->getLocale();
        // if (auth()->check() && auth()->user()->is_date_hijri) {
        if ((bool)setting('rasid_date_type')) {
            $this->changeDateLocale($locale);
            return Hijri::convertToHijri($this->updated_at)->format('d F o');
        }
        return Carbon::parse($this->updated_at)->locale($locale)->translatedFormat('j F Y');
    }

    public function getDeletedAtDateAttribute($date)
    {
        if ($date==null) return $date ;
        $locale = app()->getLocale();
        // if (auth()->check() && auth()->user()->is_date_hijri) {
        if ((bool)setting('rasid_date_type')) {
            $this->changeDateLocale($locale);
            return Hijri::convertToHijri($this->deleted_at)->format('d F o');
        }
        return Carbon::parse($this->deleted_at)->locale($locale)->translatedFormat('j F Y');
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
