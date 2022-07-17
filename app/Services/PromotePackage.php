<?php

namespace App\Services;

use App\Models\CitizenPackage;
use Carbon\Carbon;

class PromotePackage
{
    public static function createCitizenPackage($package_type)
    {
        $citizen_package_check = CitizenPackage::where('package_type', $package_type)
            ->where('citizen_id', auth()->id())->first();
        if ($citizen_package_check) {
            $citizen_package_check->update([
                'end_at' => Carbon::parse($citizen_package_check->end_at)->addMonths(12),
                'number_of_purchase' => \DB::raw('number_of_purchase + 1'),
                'package_price' => setting('rasidpay_cards_' . $package_type . '_price')??"500",
            ]);
            return $citizen_package_check;
        }
        $package_data = [
            'package_type' => $package_type,
            'package_price' => setting('rasidpay_cards_' . $package_type . '_price')??"500",
            'start_at' => now(),
            'end_at' => now()->addMonths(12)
        ];
        $citizenPackage = auth()->user()->citizenPackages()->create($package_data);
        auth()->user()->citizen()->update(['citizen_package_id' => $citizenPackage->id]);
        return $citizenPackage;
    }
}
