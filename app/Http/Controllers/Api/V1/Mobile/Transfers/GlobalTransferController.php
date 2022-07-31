<?php

namespace App\Http\Controllers\Api\V1\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Transfers\GlobalTransferRequest;
use App\Http\Resources\Api\V1\Mobile\Transactions\TransactionResource;
use App\Models\{CitizenWallet, Country\Country, Transaction, Transfer};
use App\Notifications\GeneralNotification;

class GlobalTransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('check_max_transactions')->only('store');
    }

    public function store(GlobalTransferRequest $request, Transfer $transfer)
    {
        // check main_balance is sufficient or not (This will change after this phase (clean code))
        $wallet = CitizenWallet::with('citizen')->where('citizen_id', auth()->id())->firstOrFail();
        $fees = setting('western_union_fees') ?: 0;
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
        // TODO: Calc transfer fee

        // Set transfer data
        $transfer_data = $request->only('fee_upon', 'transfer_purpose_id', 'notes')
            + [
                'transfer_type' => 'global',
                'from_user_id' => auth()->id(),
                'transfer_status' => 'pending',
                'amount' => $request->amount,
                'transfer_fee' => $fees,
                'transfer_fee_amount' => $amount_fees,
            ];

        // $balance = WalletBalance::calcWalletMainBackBalance($wallet, $request->amount);

        // $transfer_data += (array)$balance;
        $wallet->decrement('main_balance', $amount);
        // create global transfer
        $global_transfer = Transfer::create($transfer_data + ['main_amount' => $request->amount]);
        $exchange_rate = Country::find($request->to_currency_id)->countryCurrency->currency_value;
        $global_transfer->bankTransfer()->create($request->only(
            [
                'currency_id', 'to_currency_id', 'beneficiary_id', 'balance_type'
            ]
        ) + ['exchange_rate' => $exchange_rate]);
        $global_transfer->bankTransfer()->update(['recieve_option_id' => $global_transfer->beneficiary->recieve_option_id]);

        //add transfer in  transaction
        $transaction = $global_transfer->transaction()->create([
            'amount' => $request->amount,
            'trans_type' => 'global_transfer',
            "fee_upon" => $request->fee_upon,
            'from_user_id' => auth()->id(),
            'fee_amount' => $global_transfer->transfer_fees ?? 0,
            'cashback_amount' => $global_transfer->cashback_amount,
            'main_amount' => $global_transfer->main_amount,
            'trans_number' => generate_unique_code(Transaction::class, 'trans_number', 10, 'numbers'),
            'trans_status' => 'success'
        ]);

        return TransactionResource::make($transaction->refresh())->additional([
            'message' => trans('mobile.local_transfers.transfer_has_been_done_successfully'),
            'status' => true
        ]);
    }
}
