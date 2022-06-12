<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\PaymentRequest;
use App\Http\Resources\Mobile\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function store(PaymentRequest $request, Payment $payment)
    {
        $payment->fill($request->validated() + ['citizen_id' => auth()->user()->citizen->id])->save();
        // add payment transaction\
        return PaymentResource::make($payment)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_add")
            ]);
    }

}
