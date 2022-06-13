<?php

namespace App\Http\Controllers\Api\V1\Mobile;
use App\Models\{Card,Device,WalletCharge,Transaction,CitizenWallet,User};
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\WalletBinRequest;
use App\Http\Requests\V1\Mobile\WalletRequest;
use App\Http\Resources\Mobile\WalletResource;

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
        $wallet = CitizenWallet::where('citizen_id', $citizen->id)->firstOrFail();
        $walletBefore = $wallet->main_balance;
        $wallet->increment('main_balance' ,$request->amount,['last_updated_at' => now()]);
        // #2 Add charge information
        $wallet_charge = $citizen->walletCharges()->create([
            'amount' => $request->amount,
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
            $citizen->cards()->updateOrCreate(['user_id' => $citizen->id, 'card_number' => $request->card_number],array_only($request->validated(),['owner_name','card_name','card_number','expire_at']));
        }

        return WalletResource::make($wallet)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_add')
            ]);
    }
}
