<?php

namespace App\Http\Controllers\Api\V1\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\GLobalTransferRequest;
use App\Http\Resources\Mobile\Transactions\TransactionResource;
use App\Models\{CitizenWallet, Transfer};


class GlobalTransferController extends Controller
{

    public function store(GlobalTransferRequest $request, Transfer $transfer)
    {
        // check main_balance is suffienct or not
        $wallet = CitizenWallet::with('citizen')->where('citizen_id', auth()->id())->firstOrFail();
        if (
            ($request->balance_type === 'main' && ($wallet->main_balance < $request->amount)) ||
            ($request->balance_type === 'back' && ($wallet->cash_back < $request->amount))) {
            return response()->json(['data' => null, 'message' => trans('mobile.local_transfers.current_balance_is_not_sufficiant_to_complete_transaction'), 'status' => false], 422);
        }
        $wallet->update(['wallet_bin' => null]);
        // TODO: Calc transfer fee

        // Set transfer data
        $transfer_data = $request->only('amount', 'amount_transfer', 'transfer_fees', 'fee_upon') + ['transfer_type' => 'global', 'from_user_id' => auth()->id(),'transfer_status' =>'pending'];
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

        // create global transfer
        $global_transfer = Transfer::create($transfer_data);
        $global_transfer->bankTransfer()
            ->create($request->only(['currency_id', 'to_currency_id', 'beneficiary_id', 'transfer_purpose_id', 'balance_type'])
                + ['transfer_id'=>$global_transfer->id]);
        $global_transfer->update(['recieve_option_id'=> $global_transfer->beneficiary->recieve_option_id ]);

        //add transfer in  transaction
        $transaction = $global_transfer->transaction()->create([
            'amount' => $request->amount,
            'transfer_type' => 'global_transfer',
            "fee_upon" => $request->fee_upon,
            'from_user_id' => auth()->id(),
            'fee_amount' => $global_transfer->transfer_fees ?? 0,
            'cashback_amount' => $global_transfer->cashback_amount,
            'main_amount' => $global_transfer->main_amount,
        ]);

        return TransactionResource::make($transaction)->additional([
            'message' => trans('mobile.local_transfers.transfer_has_been_done_successfully'),
            'status' => true
        ]);
    }
}
