<?php

namespace App\Traits;

use App\Scopes\GlobalSearchScope;
use GeniusTS\HijriDate\{Date, Hijri, Translations\Arabic, Translations\English};
use Illuminate\Support\Str;

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

    public function getCreatedAtAttribute($date)
    {
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale();
            return Hijri::convertToHijri($date)->format('d F o  h:i A');
        }
        return date('Y-m-d h:i A', strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale();
            return Hijri::convertToHijri($date)->format('d F o   h:i A');
        }
        return date('Y-m-d h:i A', strtotime($date));
    }

    public function getDeletedAtAttribute($date)
    {
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale();
            return Hijri::convertToHijri($date)->format('d F o   h:i A');
        }
        return date('Y-m-d h:i A', strtotime($date));
    }

    public function changeDateLocale()
    {
        if (app()->getLocale() == 'en') {
            Date::setTranslation(new English);
            Date::setDefaultNumbers(Date::ARABIC_NUMBERS);
        } else {
            Date::setTranslation(new Arabic);
            Date::setDefaultNumbers(Date::INDIAN_NUMBERS);
        }
    }
}
