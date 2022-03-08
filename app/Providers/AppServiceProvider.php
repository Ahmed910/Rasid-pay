<?php

namespace App\Providers;


use GeniusTS\HijriDate\Hijri;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    const MORPH_MAP = [
        'Department' => \App\Models\Department\Department::class,
        'User'       => \App\Models\user::class,
        'Chat'       => \App\Models\Chat::class,
        'Device'     => \App\Models\Device::class,
        'Message'    => \App\Models\Message::class,
        'Permission' => \App\Models\Permission::class,
        'Setting'    => \App\Models\Setting::class,
        'Bank'       => \App\Models\Bank\Bank::class,
        'City'       => \App\Models\City\City::class,
        'Country'    => \App\Models\Country\Country::class,
        'Currency'   => \App\Models\Currency\Currency::class,
        'Group'      => \App\Models\Group\Group::class,
        'RasidJob'   => \App\Models\RasidJob\RasidJob::class,
        'Region'     => \App\Models\Region\Region::class
    ];

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
        Relation::MorphMap(static::MORPH_MAP);
    }
}
