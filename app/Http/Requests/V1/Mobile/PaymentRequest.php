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
            "invoice_number" => 'required|min:1|max:10',
            "amount" => 'required|min:1|max:10|regex:/^[\pN\,\.]+$/u',
            "description" => 'nullable|min:1|max:255',
            'payment_type' => 'required',
            "payment_data" => 'nullable|string|max:255',

        ];
    }
}
