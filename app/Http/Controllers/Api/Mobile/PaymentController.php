<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Mobile\{PaymentResource, Transactions\TransactionResource};
use App\Models\{CitizenWallet, Payment, Transaction};
use App\Services\WalletBalance;
use App\Http\Requests\Mobile\PaymentRequest;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('check_max_transactions')->only('store');
    }

    public function store(PaymentRequest $request, Payment $payment)
    {
        $citizen_wallet = CitizenWallet::with('citizen')->where('citizen_id', auth()->id())->firstOrFail();
        if ($request->amount > $citizen_wallet->main_balance) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.payments.current_balance_is_not_sufficient_to_complete_payment')], 422);
        }
        $citizen_wallet->update(['wallet_bin' => null]);
        $payment->fill($request->validated() + ['citizen_id' => auth()->id()])->save();
        $transaction_data = [
            'trans_type' => 'payment',
            'from_user_id' => auth()->id(),
            'amount' => $request->amount,
            'fee_amount' => 0, // TODO::will be added after implement api
            'trans_status' => 'success', // TODO::will be changed after implement api
            'trans_number' => generate_unique_code(Transaction::class,'trans_number',10,'numbers')
        ];
        $transaction = $payment->transaction()->create($transaction_data);
        // if transaction saved successfully, change wallet
        if ($transaction->trans_status = 'success') {
            $back_main_balance = WalletBalance::calcWalletMainBackBalance($citizen_wallet, $request->amount);
            $citizen_wallet_data = ["cash_back" => \DB::raw('cash_back - ' . $back_main_balance->cashback_amount), 'main_balance' => \DB::raw('main_balance - ' . $back_main_balance->main_amount)];
            $citizen_wallet->update($citizen_wallet_data);
        }
        return TransactionResource::make($transaction)
            ->additional([
                'status' => true,
                'message' => trans("mobile.messages.success_payment")
            ]);
    }
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return PaymentResource::make($payment)->additional(['status' => true, 'message' => '']);
    }

}
