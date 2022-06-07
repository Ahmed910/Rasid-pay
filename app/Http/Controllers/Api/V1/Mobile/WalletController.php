<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Models\User;
use App\Models\CitizenWallet;
use App\Models\Transaction;
use App\Models\Card;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\WalletRequest;
use App\Http\Resources\Mobile\WalletResource;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * @return WalletResource
     */
    public function getCitizenWallet()
    {
        return WalletResource::make(auth()->user()->citizenWallet)->additional(['status' => true, 'message' => '']);
    }

    public function chargeWallet(WalletRequest $request)
    {
        DB::beginTransaction();

        try {
            // #1 update wallet balance
            $wallet = CitizenWallet::where('citizen_id', $request->user_id)->first();
            $wallet->update(['main_balance' => $wallet->main_balance + $request->amount]);

            // #2 Add a transaction
            $citizen = User::find($wallet->citizen_id);
            $additionalData = [];
            $additionalData['user_identity'] = $citizen->identity_number;
            $additionalData['from_user_id'] = $citizen->id;
            $transaction = new Transaction;
            $transaction->fill($request->validated() + $additionalData)->save();

            // #3 Save card information
            if ($request->is_card_saved == 1) {
                $card = new Card;
                $card->fill($request->validated())->save();
            }
            DB::commit();
            return WalletResource::make($wallet)
                ->additional([
                    'status' => true,
                    'message' => __('dashboard.general.success_add')
                ]);
        } catch (\Exception $e) {
            DB::rollback();
           return response()->json(['error' => $e]);
        }



    }


}
