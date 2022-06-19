<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\PaymentRequest;
use App\Http\Resources\Mobile\PaymentResource;
use App\Models\Payment;
use App\Models\Transaction;

class PaymentController extends Controller
{

    public function store(PaymentRequest $request, Payment $payment)
    {
        $citizen_wallet = auth()->user()->citizenWallet;
        if ($request->amount > ($citizen_wallet->main_balance + $citizen_wallet->cash_back)) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('mobile.payments.current_balance_is_not_sufficient_to_complete_payment')], 422);
        }
            $payment->fill($request->validated() + ['citizen_id' => auth()->user()->citizen->id])->save();
            $transaction_data = [
                'trans_type' => 'payment',
                'from_user_id' => auth()->id(),
                'amount' => $request->amount,
                'fee_amount' => 0, // TODO::will be added after implement api
                'trans_status' => 'success', // TODO::will be changed after implement api
                'transaction_id' => uniqid(),
            ];
            $transaction = $payment->transaction()->create($transaction_data);
            // if transaction saved successfully, change wallet
            if ($transaction->trans_status = 'success') {
                $remaining_balance = $request->amount - $citizen_wallet->cash_back;
                if ($remaining_balance <= 0)
                    $citizen_wallet->update([
                        'cash_back' => $citizen_wallet->cash_back - $request->amount,
                    ]);
                else
                    $citizen_wallet->update([
                        'cash_back' => 0,
                        'main_balance' => $citizen_wallet->main_balance - $remaining_balance,
                    ]);
            }
            return PaymentResource::make($payment)
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
