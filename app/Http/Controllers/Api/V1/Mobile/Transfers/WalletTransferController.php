<?php

namespace App\Http\Controllers\Api\V1\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Transfers\WalletTransferRequest;
use App\Http\Resources\Api\V1\Mobile\{Transactions\TransactionResource};
use App\Models\{CitizenWallet, Transaction, Transfer, User};
use App\Services\WalletBalance;

class WalletTransferController extends Controller
{

    public function __construct()
    {
        $this->middleware('check_max_transactions')->only('store');
    }
    
    public function store(WalletTransferRequest $request, Transfer $transfer)
    {
        // check max value of transfer per day
        $citizen_wallet = CitizenWallet::with('citizen')->where('citizen_id', auth()->id())->firstOrFail();
        if ($request->amount > $citizen_wallet->main_balance + $citizen_wallet->cash_back) {
            return response()->json(['data' => null, 'message' => trans('mobile.local_transfers.current_balance_is_not_sufficient_to_complete_transaction'), 'status' => false], 422);
        }
        $transfers = Transfer::where('from_user_id', auth()->id())->whereDate('created_at', date('Y-m-d'))->sum('amount');
        $max_transfer_per_day = setting('rasidpay_wallettransfer_maxvalue_perday')?:10000;
        if ($transfers > $max_transfer_per_day) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.transfers.exceed_max_transfer_day')], 422);
        }
        $citizen_wallet->update(['wallet_bin' => null]);
        $receiver_citizen_wallet = null;
        $phone = null;
        if ($request->citizen_id) {
            // TODO: Check if citizen has wallet if not create one
            $receiver_citizen_wallet = CitizenWallet::with('citizen')->where('citizen_id', $request->citizen_id)->firstOrFail();
        } elseif (!$request->citizen_id && $request->wallet_transfer_method == Transfer::PHONE) {
            $phone = $request->transfer_method_value;
        }
        $back_main_balance = WalletBalance::calcWalletMainBackBalance($citizen_wallet, $request->amount);
        $citizen_wallet_data = ["cash_back" => \DB::raw('cash_back - ' . $back_main_balance->cashback_amount), 'main_balance' => \DB::raw('main_balance - ' . $back_main_balance->main_amount)];
        $citizen_wallet->update($citizen_wallet_data);
        if ($receiver_citizen_wallet) {
            $receiver_citizen_wallet->update(["cash_back" => \DB::raw('cash_back + ' . $back_main_balance->cashback_amount), 'main_balance' => \DB::raw('main_balance + ' . $back_main_balance->main_amount)]);
        }
        // create a transfer
        $data = [
            'transfer_type' => 'wallet',
            'transfer_status' => !$request->citizen_id ? Transfer::PENDING : Transfer::TRANSFERRED,
            "fee_upon" => null,
            'from_user_id' => auth()->id(),
            "to_user_id" => $request->citizen_id,
            'phone' => $phone,
            'cashback_amount' => $back_main_balance->cashback_amount,
            'main_amount' => $back_main_balance->main_amount,
            'notes' => $request->notes
        ];
        $transfer->fill($request->validated() + $data)->save();
        $transaction = $transfer->transaction()->create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $request->citizen_id,
            'amount' => $request->amount,
            'trans_type' => 'wallet_transfer',
            'trans_status' => $transfer->transfer_status == 'transfered' ? Transaction::SUCCESS : Transaction::PENDING,
            'trans_number' => generate_unique_code(Transaction::class, 'trans_number', 10, 'numbers')
        ]);

        return TransactionResource::make($transaction->refresh())->additional([
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
            ], 422);
        }
        return response()->json([
            'status' => true,
            'data' => [
                'phone_exists' => User::where('id', "<>", auth()->id())->where(['user_type' => 'citizen', 'phone' => $phone, 'register_status' => 'completed'])->exists()
            ],
            'message' => ''
        ]);
    }
}
