<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Models\User;
use App\Models\CitizenWallet;
use App\Models\Transaction;
use App\Models\WalletCharge;
use App\Models\Card;
use App\Http\Controllers\Controller;
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
        $wallet = CitizenWallet::where('citizen_id', $request->user_id)->first();
        $walletBefore = $wallet->main_balance;
        $wallet->update(['main_balance' => $walletBefore + $request->amount]);
        $walletAfter = $wallet->main_balance;

        // #2 Add charge information
        $citizen = User::find($wallet->citizen_id);
        $chargeWallet = new WalletCharge;
        $chargeWallet->fill([
                'citizen_id' => $wallet->citizen_id,
                'amount' => $request->amount,
                'wallet_before' => $walletBefore,
                'wallet_after' => $walletAfter
            ]
        )->save();

        // #3 Add a transaction
        $citizen = User::find($wallet->citizen_id);
        $additionalData = [];
        $additionalData['user_identity'] = $citizen->identity_number;
        $additionalData['from_user_id'] = $citizen->id;
        $transaction = new Transaction;
        $transaction->fill($request->validated() + $additionalData)->save();

        // #4 Save card information
        if ($request->is_card_saved == 1) {
            $card = new Card;
            $card->fill($request->validated())->save();
        }

        return WalletResource::make($wallet)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_add')
            ]);

    }


}
