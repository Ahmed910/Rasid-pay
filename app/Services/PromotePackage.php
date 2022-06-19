<?php

namespace App\Services;

use App\Models\CitizenPackage;
use Carbon\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PromotePackage
{
    public static function createCitizenPackage($package)
    {
        $citizen_package_check = CitizenPackage::where('package_id', $package->id)
            ->where('citizen_id', auth()->id())->first();
        if ($citizen_package_check) {
            $citizen_package_check->update([
                'end_at' => Carbon::parse($citizen_package_check->end_at)->addMonths($package->duration),
            ]);
            return $citizen_package_check;
        } else {
            $citizen_table = ['user_id' => auth()->id()];
            $package_data = [
                'package_id' => $package->id,
                'package_price' => $package->price,
                'package_discount' => $package->discount,
                'start_at' => now(),
                'end_at' => now()->addMonths($package->duration)
            ];
            if ($package->has_promo) {
                $package_data += [
                    'promo_discount' => $package->promo_discount,
                ];
            }
            $citizenPackage = auth()->user()->citizenPackages()->create($package_data);

            $citizen_table += [
                'citizen_package_id' => $citizenPackage->id
            ];
            auth()->user()->citizen()->update($citizen_table);
        }
        return $citizenPackage;
    }
}
