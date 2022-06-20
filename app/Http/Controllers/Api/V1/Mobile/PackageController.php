<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Resources\Api\V1\Mobile\PackageResource;
use App\Models\{CitizenPackage, CitizenPackagePromoCode, Package\Package};
use App\Http\Controllers\Controller;
use App\Services\{PromotePackage, UpdateCitizenWallet};
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->paginate((int)($request->per_page ?? config("globals.per_page")));
        return PackageResource::collection($packages)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function show($id)
    {
        $package = Package::where('is_active', true)->findOrFail($id);
        return PackageResource::make($package)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function update(Request $request, $package_id)
    {
        $package = Package::where('is_active', 1)->findOrFail($package_id);
        $citizen_wallet = auth()->user()->citizenWallet;
        if ($package->price > ($citizen_wallet->main_balance + $citizen_wallet->cash_back)) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.payments.current_balance_is_not_sufficient_to_complete_payment')], 422);
        }
        if (!$request->promo_code) {
            $citizen_package = PromotePackage::createCitizenPackage($package);
            $citizen_package_promo_codes = [
                'citizen_package_id' => $citizen_package->id,
                'promo_discount' => $package->promo_discount
            ];
            for ($i = 0; $i < $package->number_of_used; $i++) {
                $citizen_package_promo_codes += [
                    'promo_code' => generate_unique_code(CitizenPackage::class, 'promo_discount', '6'),
                ];
                $citizen_package->citizenPackagePromoCodes()->create($citizen_package_promo_codes);
                unset($citizen_package_promo_codes['promo_code']);
            }
            UpdateCitizenWallet::updateCitizenWallet($package->price);
        } else {
            $citizen_package_promo_code = CitizenPackagePromoCode::where('promo_code', $request->promo_code)->first();
            if (!$citizen_package_promo_code) {
                return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.promotion.promo_code_is_not_found')], 422);
            }
            if ($citizen_package_promo_code->is_used == 1) {
                return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.promotion.promo_code_is_used')], 422);
            }
            // take 50% of price from citizen wallet
            $package_price = $package->price * ($package->promo_discount/100);
            if ($package_price > ($citizen_wallet->main_balance + $citizen_wallet->cash_back)) {
                return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.payments.current_balance_is_not_sufficient_to_complete_payment')], 422);
            }
            PromotePackage::createCitizenPackage($package);
            UpdateCitizenWallet::updateCitizenWallet($package_price);
            $citizen_package_promo_code->update(['is_used' => true]);
            // add cash back to citizen wallet
            $promo_code_discount = $package->price * ($citizen_package_promo_code->promo_discount / 100);
            $citizen_package_promo_code->citizenPackage->citizen->citizenWallet->cash_back += $promo_code_discount;
        }


        // TODO::create transaction and notification

        return PackageResource::make($package)->additional([
            'status' => true,
            'message' => ''
        ]);
    }
}
