<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\PromotePackageRequest;
use App\Http\Requests\Mobile\VendorDiscountRequest;
use App\Http\Resources\Api\Mobile\ClientDiscountsResource;
use App\Http\Resources\Api\Mobile\PackagePromoCodesResource;
use App\Http\Resources\Api\Mobile\PackageResource;
use App\Http\Resources\Api\Mobile\Transactions\TransactionResource;
use App\Models\{CitizenPackage, CitizenPackagePromoCode, Transaction, Vendor\Vendor};
use App\Services\{PromotePackage, WalletBalance};

class PackageController extends Controller
{

    public function __construct()
    {
        $this->middleware('check_max_transactions')->only('PromotePackage');
    }

    public function index()
    {
        $packageTypes = CitizenPackage::PACKAGE_TYPES;
        return PackageResource::collection($packageTypes)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function getPromoCodes()
    {
        $citizenPackageIds = auth()->user()->citizenPackages->pluck('id')->toArray();
        $promo_codes = CitizenPackagePromoCode::isNotUsed()->whereIn('citizen_package_id', $citizenPackageIds)->latest()->get();
        return PackagePromoCodesResource::collection($promo_codes)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function PromotePackage(PromotePackageRequest $request)
    {
        // prepare data
        $package_type = $request->package_type;
        $activateBonus = ['rasidpay_platinum_firstcode_activatebonus', 'rasidpay_platinum_secondcode_activatebonus',
            'rasidpay_platinum_thirdcode_activatebonus', 'rasidpay_platinum_fourthcode_activatebonus'];
        $package_price = setting('rasidpay_cards_' . $package_type . '_price') ?? 500;
        $citizen_wallet = auth()->user()->citizenWallet;
        if ($package_price > ($citizen_wallet->main_balance + $citizen_wallet->cash_back)) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.payments.current_balance_is_not_sufficient_to_complete_payment')], 422);
        }

        if ($request->promo_code) {
            $citizen_package = $this->promoteWithPromoCode($request, $package_price, $citizen_wallet, $package_type);
            if (!isset($citizen_package->id))
                return $citizen_package;
        } else {
            $citizen_package = $this->promoteWithOutPromoCode($package_price, $citizen_wallet, $package_type);
        }
        // create promo codes for platinum package
        if ($package_type == CitizenPackage::PLATINUM) {
            $citizen_package_promo_codes = [
                'citizen_package_id' => $citizen_package->id,
            ];
            for ($i = 0; $i < 4; $i++) {
                $citizen_package_promo_codes += [
                    'promo_code' => generate_unique_code(CitizenPackage::class, 'promo_discount', 6),
                    'promo_discount' => setting($activateBonus[$i]) ?? 10,
                ];
                $citizen_package->citizenPackagePromoCodes()->create($citizen_package_promo_codes);
                unset($citizen_package_promo_codes['promo_code'], $citizen_package_promo_codes['promo_discount']);
            }
        }

        // transaction
        $transaction_data = [
            'trans_number' => generate_unique_code(Transaction::class, 'trans_number', 10, 'numbers'),
            'trans_type' => 'promote_package',
            'from_user_id' => auth()->id(),
            'amount' => isset($new_package_price) ?: $package_price,
            'trans_status' => Transaction::SUCCESS, // TODO::will be changed after implement api
        ];
        $transaction = $citizen_package->transaction()->create($transaction_data);

        // TODO::create notification

        return TransactionResource::make($transaction)->additional([
            'status' => true,
            'message' => trans('mobile.promotion.promoted_successfully')
        ]);
    }

    private function promoteWithOutPromoCode($package_price, $citizen_wallet, $package_type)
    {
        $citizen_package = PromotePackage::createCitizenPackage($package_type);
        $back_main_balance = WalletBalance::calcWalletMainBackBalance($citizen_wallet, $package_price);
        $citizen_wallet->update(["cash_back" => \DB::raw('cash_back - ' . $back_main_balance->cashback_amount), 'main_balance' => \DB::raw('main_balance - ' . $back_main_balance->main_amount)]);
        return $citizen_package;
    }

    private function promoteWithPromoCode(PromotePackageRequest $request, $package_price, $citizen_wallet, $package_type)
    {
        $citizen_package_promo_code = CitizenPackagePromoCode::where('promo_code', $request->promo_code)->first();

        // prevent the user to use his own promo codes
//        $citizenPackageIds = auth()->user()->citizenPackages->pluck('id')->toArray();
//        if (in_array($citizen_package_promo_code->citizen_package_id, $citizenPackageIds)) {
//            return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.payments.can_not_use_your_code')], 422);
//        }
        // take discount of price from citizen wallet
//        $new_package_price = $package_price - getPercentOfNumber($package_price, $citizen_package_promo_code->promo_discount);
        $new_package_price = $package_price - getPercentOfNumber($package_price, 50);  // TODO:: for now it's 50% as use case ... maybe changed later
        if ($new_package_price > ($citizen_wallet->main_balance + $citizen_wallet->cash_back)) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.payments.current_balance_is_not_sufficient_to_complete_payment')], 422);
        }
        // take new package price from citizen wallet and make promo code expired
        $citizen_package = PromotePackage::createCitizenPackage($package_type, $citizen_package_promo_code);
        $back_main_balance = WalletBalance::calcWalletMainBackBalance($citizen_wallet, $new_package_price);
        $citizen_wallet->update(["cash_back" => \DB::raw('cash_back - ' . $back_main_balance->cashback_amount), 'main_balance' => \DB::raw('main_balance - ' . $back_main_balance->main_amount)]);
        $citizen_package_promo_code->update(['is_used' => true]);

        // add cash back to owner of promo code citizen wallet
        $promo_code_discount = getPercentOfNumber($package_price, $citizen_package_promo_code->promo_discount);
        $promo_code_owner_wallet = $citizen_package_promo_code->citizenPackage?->citizen?->citizenWallet;
        $promo_code_owner_wallet->update([
            'cash_back' => $promo_code_owner_wallet->cash_back + $promo_code_discount,
        ]);
        return $citizen_package;
    }

    public function getVendorsDiscounts(VendorDiscountRequest $request)
    {
        $type = $request->package_type;
        // vendor discount
        $vendorDiscount = Vendor::with('images')
            ->select('vendor_packages.' . $type . '_discount as discount', 'vendor_translations.name', 'vendors.id')
            ->join('vendor_packages', 'vendor_packages.vendor_id', '=', 'vendors.id')
            ->join('vendor_translations', 'vendor_translations.vendor_id', '=', 'vendors.id')
            ->where('vendor_translations.locale', app()->getLocale())
            ->where('is_active', true)
            ->get();

        return ClientDiscountsResource::collection($vendorDiscount)->additional([
            'status' => true,
            'message' => ''
        ]);
    }
}
