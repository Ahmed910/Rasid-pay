<?php

namespace App\Http\Controllers\Api\V1\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\BalanceTypeRequest;
use App\Http\Requests\V1\Mobile\Transfers\LocalTransferRequest;
use App\Http\Resources\Api\V1\Mobile\{LocalTransferResource, Transactions\TransactionResource};
use App\Models\{CitizenWallet, Transaction, Transfer};

class LocalTransferController extends Controller
{
    public function store(LocalTransferRequest $request)
    {
        // check main_balance is sufficient or not
        $wallet = CitizenWallet::with('citizen')->where('citizen_id', auth()->id())->firstOrFail();
        if ($request->amount > $wallet->main_balance) {
            return response()->json(['data' => null, 'message' => trans('mobile.local_transfers.current_balance_is_not_sufficiant_to_complete_transaction'), 'status' => false], 422);
        }

        // check max value of transfer per day
        $transfers = Transfer::where('from_user_id', auth()->id())->whereDate('created_at', date('Y-m-d'))->sum('amount');
        $max_transfer_per_day = setting('rasidpay_wallettransfer_maxvalue_perday');
        if ($transfers > $max_transfer_per_day) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.transfers.exceed_max_transfer_day')], 422);
        }

        $wallet->update(['wallet_bin' => null]);
        // TODO: Calc transfer fee

        // Set transfer data
        $transfer_data = $request->only('amount', 'fee_upon', 'transfer_purpose_id', 'notes') + ['transfer_type' => 'local', 'from_user_id' => auth()->id()];

        // $balance = WalletBalance::calcWalletMainBackBalance($wallet, $request->amount);
        // $transfer_data += (array) $balance;
        $wallet->decrement('main_balance', $request->amount);

        $local_transfer = Transfer::create($transfer_data + ['main_amount' => $request->amount]);
        $local_transfer->bankTransfer()->create($request->except('amount', 'transfer_fees', 'balance_type'));

        $transaction = $local_transfer->transaction()->create([
            'amount' => $request->amount,
            'trans_type' => 'local_transfer',
            "fee_upon" => $request->fee_upon,
            'from_user_id' => auth()->id(),
            'fee_amount' => $local_transfer->transfer_fees ?? 0,
            'cashback_amount' => $local_transfer->cashback_amount,
            'main_amount' => $local_transfer->main_amount,
            'trans_number' => generate_unique_code(Transaction::class, 'trans_number', 10, 'numbers')
        ]);

        return TransactionResource::make($transaction)->additional([
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
