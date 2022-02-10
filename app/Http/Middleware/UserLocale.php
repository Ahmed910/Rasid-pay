<?php

namespace App\Http\Middleware;

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
        if (auth()->check() && auth()->user()->user_locale != $locale) {
             app()->setLocale($locale);
             auth('api')->user()->update(['user_locale' => $locale]);
        }elseif($locale != app()->getLocale() && in_array($locale,config('translatable.locales'))){
            app()->setLocale($locale);
        }
        return $next($request);
    }
}
