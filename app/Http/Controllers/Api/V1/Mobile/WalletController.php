<?php

namespace App\Http\Controllers\Api\V1\Mobile;
use App\Models\{Card,Device,WalletCharge,Transaction,CitizenWallet,User};
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\WalletBinRequest;
use App\Http\Requests\V1\Mobile\WalletRequest;
use App\Http\Resources\Mobile\WalletResource;

class WalletController extends Controller
{

    public function getCitizenWallet()
    {
        return WalletResource::make(auth()->user()->citizenWallet)->additional(['status' => true, 'message' => '']);
    }

    public function chargeWallet(WalletRequest $request)
    {
        // #1 Update wallet balance
        $wallet = CitizenWallet::with('citizen')->where('citizen_id', $request->user_id)->firstOrFail();
        $walletBefore = $wallet->main_balance;
        $wallet->increment('main_balance' ,$request->amount);

        // #2 Add charge information

       $wallet_charge = WalletCharge::create([
            'citizen_id' => $wallet->citizen_id,
            'amount' => $request->amount,
            'wallet_before' => $walletBefore,
            'wallet_after' => $wallet->main_balance
        ]);

        // #3 Add a transaction
        $transaction_data = [
            'user_identity' => $wallet->citizen->identity_number,
            'from_user_id' => $wallet->citizen_id,
            'trans_type' => $request->trans_type
        ];
        $wallet_charge->transaction()->create($transaction_data);

        // #4 Save card information
        if ($request->is_card_saved == 1) {
            Card::create(array_only($request->validated(),['owner_name','card_name','card_number','expire_at']));

        }

        return WalletResource::make($wallet)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_add')
            ]);

    }

    public function checkForWalletBin(WalletBinRequest $request)
    {

        $user = auth()->user();
        if($request->wallet_bin != $user->citizenWallet?->wallet_bin) {

            $user->citizenWallet()->increment('number_of_tries', 1);
            if ($user->citizenWallet?->number_of_tries == 3) {
                // auth()->logout();
                $device = Device::where('user_id', $user->id)->first();
                if ($device) {
                    $device->delete();
                }
                $user->currentAccessToken()->delete();
               // return response()->json(['data'=>null,'status'=>false,'message'=>trans('mobile.messages.your_tries_have_been_expired')],412);
            }
        }
        return response()->json(['data'=>null,'status'=>true,'message'=>trans('mobile.messages.you_can_complete_your_transaction')]);
    }


}
