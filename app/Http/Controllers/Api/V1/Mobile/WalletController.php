<?php

namespace App\Http\Controllers\Api\V1\Mobile;
use App\Models\CitizenWallet;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\{WalletBinRequest, WalletRequest};
use App\Http\Resources\Api\V1\Mobile\WalletResource;
use Illuminate\Http\Request;

class WalletController extends Controller
{

    public function index()
    {
        // $wallet = auth()->user()->citizenWallet;
        // $wallet->update([
        //     'last_updated_at' => now()
        // ]);
        return WalletResource::make(auth()->user()->citizenWallet)->additional(['status' => true, 'message' => '']);
    }

    public function store(WalletRequest $request)
    {
        $citizen = auth()->user();
        // #1 Update wallet balance
        $wallet = CitizenWallet::with('citizen')->where('citizen_id', $citizen->id)->firstOrFail();
        $walletBefore = $wallet->main_balance;
        $wallet->increment('main_balance' ,$request->amount,['last_updated_at' => now()]);
        // #2 Add charge information
        $wallet_charge = $citizen->walletCharges()->create([
            'amount' => $request->amount,
            'charge_type' => $request->charge_type ?? 'exists',
            'wallet_before' => $walletBefore,
            'wallet_after' => $wallet->main_balance
        ]);
        // #3 Add a transaction
        $transaction_data = [
            'from_user_id' => $wallet->citizen_id,
            'amount' => $request->amount,
            'trans_type' => 'charge'
        ];
        $wallet_charge->transaction()->create($transaction_data);

        // #4 Save card information
        if ($request->is_card_saved == 1) {
            $citizen->cards()->updateOrCreate(['user_id' => $citizen->id, 'card_number' => $request->card_number],array_only($request->validated(),['owner_name','card_name','card_number','expire_at','card_type']));
        }

        return WalletResource::make($wallet)
            ->additional([
                'status' => true,
                'message' => __('mobile.messages.success_charge')
            ]);
    }

    public function sendWalletOtp(Request $request)
    {
        $otp = generate_unique_code(CitizenWallet::class, 'wallet_bin', 6);
        auth()->user()->citizenWallet()->updateOrCreate(['citizen_id' => auth()->id()],['wallet_bin' => $otp]);
        #send otp to auth user
        return response()->json(['status' => true, 'message' => trans('dashboard.general.success_send'),'data' => ['dev_message' => $otp]]);
    }

    public function checkOtp(Request $request)
    {
        $this->validate($request, ["otp" => "required|max:10"]);

        $result = auth()->user()->citizenWallet->wallet_bin === $request->otp;

        $data = ["is_opt_vaild" => $result];

        return response()->json(['status' => true,
            'message' => trans($result ? "mobile.validation.mobile.otp_vaild" : "mobile.validation.mobile.otp_invaild"),
            'data' => $data]);
    }
}
