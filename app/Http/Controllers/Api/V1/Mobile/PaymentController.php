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
        $payment->fill($request->validated() + ['citizen_id' => auth()->user()->citizen->id])->save();
        // TODO::will add transaction after implement api of payment
        $transaction_data = [
            'trans_type' => 'pay',
            'from_user_id' => auth()->id(),
            'amount' => $request->amount,
            'trans_status' => 'success',
            'transaction_id' => uniqid()
        ];
//        $transaction = $payment->transaction()->create($transaction_data);
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
