<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $locale = app()->getLocale();
            if ($request->is("$locale/dashboard") || $request->is('dashboard') || $request->is('dashboard/*') || $request->is("$locale/dashboard/*")) {
                return route('dashboard.login');
            }
        }
    }
}
