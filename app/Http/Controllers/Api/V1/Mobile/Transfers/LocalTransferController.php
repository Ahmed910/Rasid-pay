<?php

namespace App\Http\Controllers\Api\V1\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\BalanceTypeRequest;
use App\Http\Requests\V1\Mobile\Transfers\LocalTransferRequest;
use App\Http\Resources\Api\V1\Mobile\{LocalTransferResource, Transactions\TransactionResource};
use App\Models\{CitizenWallet, Device, Transaction, Transfer};
use App\Services\WalletBalance;

class LocalTransferController extends Controller
{
    public function store(LocalTransferRequest $request)
    {
        // check main_balance is suffienct or not
        $wallet = CitizenWallet::with('citizen')->where('citizen_id', auth()->id())->firstOrFail();
        if ($request->amount > ($wallet->main_balance + $wallet->cash_back)) {
            return response()->json(['data' => null, 'message' => trans('mobile.local_transfers.current_balance_is_not_sufficiant_to_complete_transaction'), 'status' => false], 422);
        }
        $wallet->update(['wallet_bin' => null]);
        // TODO: Calc transfer fee

        // Set transfer data
        $transfer_data = $request->only('amount', 'fee_upon','transfer_purpose_id') + ['transfer_type' => 'local', 'from_user_id' => auth()->id()];

        $balance = WalletBalance::calcWalletMainBackBalance($wallet, $request->amount);
        $transfer_data += (array) $balance;
        $wallet->update(['cash_back', \DB::raw('cash_back - '. $balance->cashback_amount),'main_balance', \DB::raw('main_balance - '. $balance->main_amount)]);

        $local_transfer = Transfer::create($transfer_data);
        $local_transfer->bankTransfer()->create($request->except('amount', 'transfer_fees','balance_type'));

        $transaction = $local_transfer->transaction()->create([
            'amount' => $request->amount,
            'transfer_type' => 'local_transfer',
            "fee_upon" => $request->fee_upon,
            'from_user_id' => auth()->id(),
            'fee_amount' => $local_transfer->transfer_fees ?? 0,
            'cashback_amount' => $local_transfer->cashback_amount,
            'main_amount' => $local_transfer->main_amount,
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
