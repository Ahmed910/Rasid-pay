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
        'Region'     => \App\Models\Region\Region::class,
        'Transaction' => \App\Models\Transaction::class,
        'Client' => \App\Models\Client::class,
        'Citizen' => \App\Models\Citizen::class,
      "BankBranch"=>\App\Models\BankBranch\BankBranch::class

    ];

    public function register()
    {
        Builder::macro("CustomDateFromTo",  function ($request) {
            if (isset($request->created_from)) {
                $created_from = date('Y-m-d', strtotime($request->created_from));
                if (auth()->user()->is_date_hijri == 1) {
                    $date = explode("-", $created_from);
                    $created_from = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
                }
                $this->whereDate('created_at', ">=", $created_from);
            }

            if (isset($request->created_to)) {
                $created_to = date('Y-m-d', strtotime($request->created_to));
                if (auth()->user()->is_date_hijri == 1) {
                    $date = explode("-", $created_to);
                    $created_to = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
                }
                $this->whereDate('created_at', "<=", $created_to);
            }
        });

        Builder::macro("searchDeletedAtFromTo",  function ($request) {
              if (isset($request->deleted_from)) {
                $deleted_from = date('Y-m-d', strtotime($request->deleted_from));
                if (auth()->user()->is_date_hijri == 1) {
                    $date = explode("-", $deleted_from);
                    $deleted_from = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
                }
                $this->whereDate('deleted_at', ">=", $deleted_from);
            }

            if (isset($request->deleted_to)) {
                $deleted_to = date('Y-m-d', strtotime($request->deleted_to));
                if (auth()->user()->is_date_hijri == 1) {
                    $date = explode("-", $deleted_to);
                    $deleted_to = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
                }
                $this->whereDate('deleted_at', "<=", $deleted_to);
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
