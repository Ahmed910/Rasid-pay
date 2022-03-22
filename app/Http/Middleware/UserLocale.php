<?php

namespace App\Http\Middleware;

use GeniusTS\HijriDate\{Date, Translations\Arabic, Translations\English};

use Closure;

class UserLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->header('Accept-Language');
        // if (auth()->check() && auth()->user()->is_date_hijri) {
        //     if ($locale == 'en') {
        //         Date::setTranslation(new English);
        //         Date::setDefaultNumbers(Date::ARABIC_NUMBERS);
        //     } else {
        //         Date::setTranslation(new Arabic);
        //         Date::setDefaultNumbers(Date::INDIAN_NUMBERS);
        //     }
        // }
        if (auth()->check() && $locale && auth()->user()->user_locale != $locale) {
            app()->setLocale($locale);
            auth()->user()->update(['user_locale' => $locale]);
        } elseif ($locale != app()->getLocale() && in_array($locale, config('translatable.locales'))) {
            app()->setLocale($locale);
        }
        return $next($request);
    }
}
