<?php

namespace App\Http\Controllers\Api\V1\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\BalanceTypeRequest;
use App\Http\Requests\V1\Mobile\LocalTransferRequest;
use App\Http\Resources\Mobile\{LocalTransferResource, Transactions\TransactionResource};
use App\Models\{CitizenWallet, Device, Transaction, Transfer};


class LocalTransferController extends Controller
{
    public function store(LocalTransferRequest $request)
    {
        // check main_balance is suffienct or not
        $wallet = CitizenWallet::with('citizen')->where('citizen_id', auth()->id())->firstOrFail();

        if (
            ($request->balance_type === 'main' && ($wallet->main_balance < $request->amount)) ||
            ($request->balance_type === 'back' && ($wallet->cash_back < $request->amount))) {
            return response()->json(['data' => null, 'message' => trans('mobile.local_transfers.current_balance_is_not_sufficiant_to_complete_transaction'), 'status' => false], 422);
        }
        // TODO: Calc transfer fee

        // Set transfer data
        $transfer_data = $request->only('amount', 'fee_upon') + ['transfer_type' => 'local', 'from_user_id' => auth()->id()];
        if ($request->balance_type == 'main') {
            $transfer_data += ['main_amount' => $request->amount];
            $wallet->decrement('main_balance', $request->amount);
        }elseif ($request->balance_type == 'back') {
            $transfer_data += ['cashback_amount' => $request->amount];
            $wallet->decrement('cash_back', $request->amount);
        }else{
            $balance = WalletBalance::calcWalletMainBackBalance($wallet, $request->amount);
            $transfer_data += (array) $balance;
            $wallet->update(['cash_back', \DB::raw('cash_back - '. $balance->cashback_amount),'main_balance', \DB::raw('main_balance - '. $balance->main_amount)]);
        }
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
