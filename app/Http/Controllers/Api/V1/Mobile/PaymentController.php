<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\PaymentRequest;
use App\Http\Resources\Mobile\{PaymentResource, Transactions\TransactionResource};
use App\Models\{Payment, Transaction};
use App\Services\WalletBalance;

class PaymentController extends Controller
{
    public function store(PaymentRequest $request, Payment $payment)
    {
        $citizen_wallet = auth()->user()->citizenWallet;
        if ($request->amount > ($citizen_wallet->main_balance + $citizen_wallet->cash_back)) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.payments.current_balance_is_not_sufficient_to_complete_payment')], 422);
        }
        $payment->fill($request->validated() + ['citizen_id' => auth()->id()])->save();
        $transaction_data = [
            'trans_type' => 'payment',
            'from_user_id' => auth()->id(),
            'amount' => $request->amount,
            'fee_amount' => 0, // TODO::will be added after implement api
            'trans_status' => 'success', // TODO::will be changed after implement api
            // 'transaction_id' => ,// TODO::will be changed after implement api (return from api)
        ];
        $transaction = $payment->transaction()->create($transaction_data);
        // if transaction saved successfully, change wallet
        if ($transaction->trans_status = 'success') {
            $back_main_balance = WalletBalance::calcWalletMainBackBalance($citizen_wallet, $request->amount);
            $citizen_wallet->update([
                'cash_back' => $back_main_balance->cashback_amount,
                'main_balance' => $back_main_balance->main_amount,
            ]);
        }
        return TransactionResource::make($transaction)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_add")
            ]);
    }
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return PaymentResource::make($payment)->additional(['status' => true, 'message' => '']);
    }

}
