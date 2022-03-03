<?php

namespace App\Providers;

use GeniusTS\HijriDate\Hijri;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Builder::macro("CustomDateFromTo",  function ($request) {
            if ($request->created_from) {
                $created_from = date('Y-m-d', strtotime($request->created_from));
                if (auth()->user()->is_date_hijri == 1) {
                    $date = explode("-", $created_from);
                    $created_from = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
                }
                $this->whereDate('created_at', ">=", $created_from);
            }

            if ($request->created_to) {
                $created_to = date('Y-m-d', strtotime($request->created_to));
                if (auth()->user()->is_date_hijri == 1) {
                    $date = explode("-", $created_to);
                    $created_to = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
                }
                $this->whereDate('created_at', "<=", $created_to);
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
