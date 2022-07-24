<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';
    protected $dashboard_v1_namespace = 'App\\Http\\Controllers\\Api\\V1\\Dashboard';
    protected $blade_dashboard_namespace = 'App\\Http\\Controllers\\Blade\\Dashboard';
    protected $mobile_v1_namespace = 'App\\Http\\Controllers\\Api\\V1\\Mobile';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api/v1/dashboard')
                ->middleware('api', 'setLocale') //adminPermission
                ->namespace($this->dashboard_v1_namespace)
                ->group(base_path('routes/v1/dashboard.php'));

            Route::middleware('web') //adminPermission
                ->namespace($this->blade_dashboard_namespace)
                ->group(base_path('routes/dashboard/web.php'));

            Route::prefix('api/v1007/mobile')
                ->middleware('api', 'setLocale') //
                ->namespace($this->mobile_v1_namespace)
                ->group(base_path('routes/v1/mobile.php'));

            Route::prefix('api/v1008/mobile')
                ->middleware('api', 'setLocale') //
                ->namespace($this->mobile_v1_namespace)
                ->group(base_path('routes/v1/mobile.php'));

            Route::prefix('api/v1006/mobile')
                ->middleware('api', 'setLocale') //
                ->namespace($this->mobile_v1_namespace)
                ->group(base_path('routes/v1/mobile.php'));

            Route::prefix('api/v1/mobile')
                ->middleware('api', 'setLocale') //
                ->namespace($this->mobile_v1_namespace)
                ->group(base_path('routes/v1/mobile.php'));

            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute((int)(setting('number_of_requests_per_minute') ?? 60))->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
