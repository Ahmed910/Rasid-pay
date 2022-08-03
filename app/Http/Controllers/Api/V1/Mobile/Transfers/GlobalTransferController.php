<?php

namespace App\Http\Controllers\Api\V1\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Transfers\GlobalTransferRequest;
use App\Http\Resources\Api\V1\Mobile\Transactions\TransactionResource;
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
        $sar_per_dollar = Currency::where('currency_code', 'USD')->select('currency_value')->value('currency_value');
        $amount = $request->amount;
        $amount_per_dollar = $amount * $sar_per_dollar;
        // dd($amount_per_dollar);

        $transfer_fees = TransferFee::whereRaw('CAST(amount_from AS DECIMAL) <= ? AND CAST(amount_to AS DECIMAL) >= ?', [$amount_per_dollar, $amount_per_dollar])->first();

        if (!$transfer_fees) {
            $transfer_fee = TransferFee::max('amount_to');
            $transfer_fees = TransferFee::create(['amount_from' => ++$transfer_fee, 'amount_to' => $amount_per_dollar, 'amount_fee' => 40]);
        }
        // $fees = setting('western_union_fees') ?: 0;
        $fees_per_dollar = $transfer_fees->amount_fee;

        $fees = $fees_per_dollar / $sar_per_dollar;
        $fee_upon = $request->fee_upon;
        if ($amount > $wallet->main_balance) {

            return response()->json(['data' => null, 'message' => trans('mobile.local_transfers.current_balance_is_not_sufficient_to_complete_transaction'), 'status' => false], 422);
        }
        $wallet->update(['wallet_bin' => null]);
        // TODO: Calc transfer fee

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

        // $balance = WalletBalance::calcWalletMainBackBalance($wallet, $request->amount);

        // $transfer_data += (array)$balance;
        $wallet->decrement('main_balance', $amount);
        // create global transfer
        $global_transfer = Transfer::create($transfer_data + ['main_amount' => $request->amount]);
        $exchange_rate = Country::find($request->to_currency_id)->countryCurrency?->currency_value;
        $global_transfer->bankTransfer()->create($request->only(
                [
                    'currency_id', 'to_currency_id', 'beneficiary_id', 'balance_type'
                ]
            ) + [
                'exchange_rate' => $exchange_rate,
                //TODO: generate mtcn number from westren union api
                'mtcn_number' => generate_unique_code(BankTransfer::class, 'mtcn_number', 8, 'numbers'),
            ]);
        $global_transfer->bankTransfer()->update(['recieve_option_id' => $global_transfer->beneficiary?->recieve_option_id]);

        //add transfer in  transaction
        $transaction = $global_transfer->transaction()->create([
            'amount' => $amount - $fees,
            'trans_type' => 'global_transfer',
            "fee_upon" => $request->fee_upon,
            'from_user_id' => auth()->id(),
            'fee_amount' => $fees ?? 0,
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
