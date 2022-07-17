<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\PackageRequest;
use App\Http\Resources\Api\V1\Mobile\ClientDiscountsResource;
use App\Http\Resources\Api\V1\Mobile\PackagePromoCodesResource;
use App\Http\Resources\Api\V1\Mobile\PackageResource;
use App\Http\Resources\Api\V1\Mobile\Transactions\TransactionResource;
use App\Models\{CitizenPackage, CitizenPackagePromoCode, Package\Package, Transaction};
use App\Services\{PromotePackage, WalletBalance};
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packageTypes = CitizenPackage::PACKAGE_TYPES;
        return PackageResource::collection($packageTypes)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function show($package_type)
    {
        $packageTypes = CitizenPackage::PACKAGE_TYPES[$package_type];
        return PackageResource::make($packageTypes)->additional([
            'status' => true,
            'message' => ''
        ]);
    }


    public function getPromoCodes()
    {
        $promo_codes = auth()->user()->citizen->enabledPackage->citizenPackagePromoCodes()->paginate((int)($request->per_page ?? config("globals.per_page")));
        return PackagePromoCodesResource::collection($promo_codes)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function update(Request $request, $package_type)
    {
        if (!in_array($package_type, CitizenPackage::PACKAGE_TYPES)) {
            return response()->json(['status' => false, 'data' => null, 'message' => 'Package type not found'], 422);
        }

        $activateBonus = ['rasidpay_platinum_firstcode_activatebonus', 'rasidpay_platinum_secondcode_activatebonus',
            'rasidpay_platinum_thirdcode_activatebonus', 'rasidpay_platinum_fourthcode_activatebonus'];

        $package_price = setting('rasidpay_cards_' . $package_type . '_price')??500;
        $citizen_wallet = auth()->user()->citizenWallet;
        if ($package_price > ($citizen_wallet->main_balance + $citizen_wallet->cash_back)) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.payments.current_balance_is_not_sufficient_to_complete_payment')], 422);
        }
        if (!$request->promo_code) {
            $citizen_package = PromotePackage::createCitizenPackage($package_type);
            $citizen_package_promo_codes = [
                'citizen_package_id' => $citizen_package->id,
            ];
            for ($i = 0; $i < 4; $i++) {
                $citizen_package_promo_codes += [
                    'promo_code' => generate_unique_code(CitizenPackage::class, 'promo_discount', 6),
                    'promo_discount' => setting($activateBonus[$i])??10,
                ];
                $citizen_package->citizenPackagePromoCodes()->create($citizen_package_promo_codes);
                unset($citizen_package_promo_codes['promo_code'],$citizen_package_promo_codes['promo_discount']);
            }
            $back_main_balance = WalletBalance::calcWalletMainBackBalance($citizen_wallet, $package_price);
        } else {
            $citizen_package_promo_code = CitizenPackagePromoCode::where('promo_code', $request->promo_code)->first();
            if (!$citizen_package_promo_code) {
                return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.promotion.promo_code_is_not_found')], 422);
            }
            if ($citizen_package_promo_code->is_used == 1) {
                return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.promotion.promo_code_is_used')], 422);
            }
            // take discount of price from citizen wallet
            $new_package_price = $package_price - getPercentOfNumber($package_price, $citizen_package_promo_code->promo_discount);
            if ($new_package_price > ($citizen_wallet->main_balance + $citizen_wallet->cash_back)) {
                return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.payments.current_balance_is_not_sufficient_to_complete_payment')], 422);
            }

            $citizen_package = PromotePackage::createCitizenPackage($package_type);
            $back_main_balance = WalletBalance::calcWalletMainBackBalance($citizen_wallet, $new_package_price);
            $citizen_package_promo_code->update(['is_used' => true]);
            // add cash back to citizen wallet
            $promo_code_discount = getPercentOfNumber($package_price, $citizen_package_promo_code->promo_discount);
            $promo_code_owner_wallet = $citizen_package_promo_code->citizenPackage->citizen->citizenWallet;
            $promo_code_owner_wallet->update([
                'cash_back' => $promo_code_owner_wallet->cash_back + $promo_code_discount,
            ]);
        }
        $citizen_wallet->update(["cash_back" => \DB::raw('cash_back - ' . $back_main_balance->cashback_amount), 'main_balance' => \DB::raw('main_balance - ' . $back_main_balance->main_amount)]);

        $transaction_data = [
            'trans_number' => generate_unique_code(Transaction::class,'trans_number',10,'numbers'),
            'trans_type' => 'promote_package',
            'from_user_id' => auth()->id(),
            'amount' => isset($new_package_price) ?: $package_price,
            'trans_status' => 'success', // TODO::will be changed after implement api
        ];
        $transaction = $citizen_package->transaction()->create($transaction_data);

        // TODO::create notification

        return TransactionResource::make($transaction)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function getVendorsDiscounts($package_type)
    {
        $package = Package::with('clients')->findOrFail($package_id);
        $clients = $package->clients()->paginate((int)($request->per_page ?? config("globals.per_page")));
        return ClientDiscountsResource::collection($clients)->additional([
            'status' => true,
            'message' => ''
        ]);
    }
}
