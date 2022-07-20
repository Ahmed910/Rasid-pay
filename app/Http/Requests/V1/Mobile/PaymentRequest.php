<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;

class PaymentRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "invoice_number" => 'required|unique:payments,invoice_number',
            "amount" => 'required|min:1|max:10|gt:0|regex:/^[\pN\,\.]+$/u',
            "description" => 'nullable|min:1|max:255',
            'payment_type' => 'required',
            "payment_data" => 'nullable|string|max:255',
            "otp_code" => 'required|exists:citizen_wallets,wallet_bin,citizen_id,'.auth()->id(),
        ];
    }

    public function messages()
    {
      return [
          'invoice_number.unique' => trans('mobile.payment.is_paid_before'),
      ];
    }
}
