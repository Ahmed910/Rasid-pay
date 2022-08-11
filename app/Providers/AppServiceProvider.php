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
        'User'       => \App\Models\User::class,
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
        "BankBranch" => \App\Models\BankBranch\BankBranch::class,
        'Vendor'   => \App\Models\Vendor\Vendor::class,
        'VendorBranch'   => \App\Models\VendorBranches\VendorBranch::class,
        'MessageType' => \App\Models\MessageType\MessageType::class,
        'VendorPackage' => \App\Models\VendorPackage::class,
        'Contact' => \App\Models\Contact::class,
        'Transfer' => \App\Models\Transfer::class,
        'BankTransfer' => \App\Models\BankTransfer::class,
        'Card' => \App\Models\Card::class,
        'Admin' => \App\Models\Admin::class,
        'Faq'   => \App\Models\Faq\Faq::class,
        'Curreny' => \App\Models\Currency\Currency::class,
        'OurApp' => \App\Models\OurApp\OurApp::class,
        'Slide'      => \App\Models\Slide::class,
        'Package' => \App\Models\Package\Package::class,
        'RecieveOption' => \App\Models\RecieveOption\RecieveOption::class,
        'StaticPage'    => \App\Models\StaticPage\StaticPage::class,
        'TransferPurpose' => \App\Models\TransferPurpose\TransferPurpose::class,
        'TransferRelation'=> \App\Models\TransferRelation\TransferRelation::class,
        'ActivityLog' => \App\Models\ActivityLog::class,
        'Locale' => \App\Models\Locale\Locale::class
    ];

    public function register()
    {
        Builder::macro("customDateFromTo",  function ($request, $columnName = 'created_at', $dateFrom = 'created_from', $dateTo = 'created_to') {
            if (isset($request->{$dateFrom})) {
                $created_from = date('Y-m-d', strtotime($request->{$dateFrom}));
                if (setting('rasid_date_type')) {
                    $date = explode("-", $created_from);
                    $created_from = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
                }
                $this->whereDate($columnName, ">=", $created_from);
            }

            if (isset($request->{$dateTo})) {
                $created_to = date('Y-m-d', strtotime($request->{$dateTo}));
                if (setting('rasid_date_type')) {
                    $date = explode("-", $created_to);
                    $created_to = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
                }
                $this->whereDate($columnName, "<=", $created_to);
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
