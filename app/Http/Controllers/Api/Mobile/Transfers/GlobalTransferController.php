<?php

namespace App\Http\Controllers\Api\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Transfers\GlobalTransferRequest;
use App\Http\Resources\Api\Mobile\Transactions\TransactionResource;
use App\Models\{BankTransfer, CitizenWallet, Country\Country, Currency, Transaction, Transfer, TransferFee};

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
        $sar_per_dollar = (double)Currency::where('currency_code', 'USD')->select('currency_value')->value('currency_value');
        $amount = $request->amount;
        $amount_per_dollar = $amount * $sar_per_dollar;
        $transfer_fees = TransferFee::whereRaw('CAST(amount_from AS DECIMAL) <= ? AND CAST(amount_to AS DECIMAL) >= ?', [$amount_per_dollar, $amount_per_dollar])->first();
        $fees_per_dollar = $transfer_fees->amount_fee;

        $fees = $fees_per_dollar / $sar_per_dollar;
        $fee_upon = $request->fee_upon;
        if ($fee_upon == Transfer::FROM_USER) {
            if (($amount + $fees) > $wallet->main_balance) {
                return response()->json(['data' => null, 'message' => trans('mobile.local_transfers.current_balance_is_not_sufficient_to_complete_transaction'), 'status' => false], 422);
            }
            $amount += $fees;
        } else {
            if ($amount > $wallet->main_balance) {
                return response()->json(['data' => null, 'message' => trans('mobile.local_transfers.current_balance_is_not_sufficient_to_complete_transaction'), 'status' => false], 422);
            }
            $amount -= $fees;
        }
        $wallet->update(['wallet_bin' => null]);

        // Set transfer data
        $transfer_data = $request->only('fee_upon', 'transfer_purpose_id', 'notes')
            + [
                'transfer_type' => 'global',
                'from_user_id' => auth()->id(),
                'transfer_status' => 'pending',
                'amount' => $amount - $fees,
                'transfer_fees' => $fees,
                'transfer_fees_amount' => $fees,
            ];

        $wallet->decrement('main_balance', $amount);
        // create global transfer
        $global_transfer = Transfer::create($transfer_data + ['main_amount' => $request->amount]);
        }
    }
