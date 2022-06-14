<?php

namespace App\Http\Controllers\Api\V1\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Transfers\WalletTransferRequest;
use App\Http\Resources\Mobile\{LocalTransferResource, WalletTransferResource};
use App\Models\{CitizenWallet, User,Transfer};
use Illuminate\Http\Request;

class WalletTransferController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(WalletTransferRequest $request, Transfer $transfer)
    {
        $citizen_wallet = CitizenWallet::with('citizen')->where('citizen_id', auth()->id())->firstOrFail();
        $citizen_wallet->update(['wallet_bin' => null]);
        $receiver_citizen_wallet = null;
        $phone = null;
        if ($request->citizen_id) {
            // TODO: Check if citizen has wallet if not create one
            $receiver_citizen_wallet = CitizenWallet::with('citizen')->where('citizen_id', $request->citizen_id)->firstOrFail();
        }elseif (!$request->citizen_id && in_array($request->transfer_status,['hold','transfered'])) {
            $phone = $request->transfer_method_value;
        }

        if ($request->amount > $citizen_wallet->main_balance + $citizen_wallet->cash_back){
            return response()->json(['data' => null, 'message' => trans('mobile.local_transfers.current_balance_is_not_sufficiant_to_complete_transaction'), 'status' => false], 422);
        }
        $main_amount = 0;
        $cashback_amount = $request->amount;
        if ($request->amount > $citizen_wallet->cash_back) {
            $cashback_amount = $citizen_wallet->cash_back;
            $main_amount = $request->amount - $cashback_amount;
        }
        $citizen_wallet_data =  ["cash_back" => \DB::raw('cash_back - '.$cashback_amount), 'main_balance' => \DB::raw('main_balance - '.$main_amount)];

        if ($request->transfer_status == 'hold') {
            $citizen_wallet_data +=  ['hold_back_balance' =>  $cashback_amount, 'hold_main_balance' => $main_amount];
        }
        $citizen_wallet->update($citizen_wallet_data);
        if ($receiver_citizen_wallet) {
            $receiver_citizen_wallet->update(["cash_back" => \DB::raw('cash_back + '.$cashback_amount), 'main_balance' => \DB::raw('main_balance + '.$main_amount)]);
        }
        // create a transfer
        $data = [
            'transfer_type' => 'wallet',
            'transfer_status' => $request->transfer_status ?? 'transfered',
            "fee_upon" => null,
            'from_user_id' => auth()->id(),
            "to_user_id" => $request->citizen_id,
            'phone' => $phone,
            'cashback_amount' => $cashback_amount,
            'main_amount' => $main_amount,
        ];
        $transfer->fill($request->validated() + $data)->save();
        $transfer->transaction()->create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $request->citizen_id,
            'amount' => $request->amount,
            'trans_type' => 'transfer'
        ]);
        return WalletTransferResource::make($transfer)->additional([
            'message' => trans('mobile.local_transfers.transfer_has_been_done_successfully'),
            'status' => true
            ]);
    }

    public function checkIfPhoneExists($phone)
    {
        if (!check_phone_valid($phone)) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => trans('mobile.validation.invalid_phone')
            ],422);
        }
        return response()->json([
            'status' => true,
            'data' => [
                'phone_exists' => User::where('id',"<>",auth()->id())->where(['user_type' => 'citizen', 'phone' => $phone])->exists()
            ],
            'message' => ''
        ]);
    }
}
