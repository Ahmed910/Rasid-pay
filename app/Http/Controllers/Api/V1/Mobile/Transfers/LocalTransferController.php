<?php

namespace App\Http\Controllers\Api\V1\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Transfers\LocalTransferRequest;
use App\Http\Resources\Api\V1\Mobile\{LocalTransferResource, Transactions\TransactionResource};
use App\Models\{CitizenWallet, Transaction, Transfer};

class LocalTransferController extends Controller
{
    public function __construct()
    {
       $this->middleware('check_max_transactions')->only('store');
    }

    public function store(LocalTransferRequest $request)
    {

        $wallet = CitizenWallet::with('citizen')->where('citizen_id', auth()->id())->firstOrFail();
        $fees = setting('rasidpay_localtransfer_transferfees') ?: 7;
        $amount = $request->amount;
        // calculate fees
        $amount_fees = getPercentOfNumber($amount, $fees);
        $fee_upon = $request->fee_upon;
        if ($fee_upon == Transfer::FROM_USER) {
            if (($amount + $amount_fees) > $wallet->main_balance) {
                return response()->json(['data' => null, 'message' => trans('mobile.local_transfers.current_balance_is_not_sufficient_to_complete_transaction'), 'status' => false], 422);
            }
            $amount += $amount_fees;
        } else {
            if ($amount > $wallet->main_balance) {
                return response()->json(['data' => null, 'message' => trans('mobile.local_transfers.current_balance_is_not_sufficient_to_complete_transaction'), 'status' => false], 422);
            }
            // $amount -= $amount_fees;
        }
        $wallet->update(['wallet_bin' => null]);
        // Set transfer data
        $transfer_data = $request->only('fee_upon', 'transfer_purpose_id', 'notes') +
            [
                'transfer_type' => 'local',
                'from_user_id' => auth()->id(),
                'amount' => $request->amount,
                'transfer_fees' => $fees,
                'transfer_fees_amount' => $amount_fees,
            ];
        $wallet->decrement('main_balance', $amount);
        $local_transfer = Transfer::create($transfer_data + ['main_amount' => $amount]);
        $local_transfer->bankTransfer()->create($request->except('amount', 'transfer_fees', 'balance_type'));
        $transaction = $local_transfer->transaction()->create([
            'amount' => $amount,
            'trans_type' => 'local_transfer',
            "fee_upon" => $request->fee_upon,
            'from_user_id' => auth()->id(),
            'fee_amount' => $amount_fees,
            'cashback_amount' => $local_transfer->cashback_amount,
            'main_amount' => $local_transfer->main_amount,
            'trans_number' => generate_unique_code(Transaction::class, 'trans_number', 10, 'numbers')
        ]);

        return TransactionResource::make($transaction->refresh())->additional([
            'message' => trans('mobile.local_transfers.transfer_has_been_done_successfully'),
            'status' => true
        ]);
    }

    public function getLocalTransfer($id)
    {
        $transfer = Transfer::with('bank_transfer')->findOrFail($id);

        return LocalTransferResource::make($transfer)->additional(['status' => true, 'message' => ""]);
    }


}
