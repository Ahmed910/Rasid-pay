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
            "amount" => ['required', 'regex:/^\\d{1,5}$|^\\d{1,5}\\.\\d{0,2}$/', 'numeric'],
            "description" => 'nullable|min:1|max:255',
            'payment_type' => 'required',
            "payment_data" => 'nullable|string|max:255',
            "otp_code" => 'required|exists:citizen_wallets,wallet_bin,citizen_id,' . auth()->id(),

        ];
    }
    protected function prepareForValidation()
    {
        $data = $this->all();

        $this->merge([
            'invoice_number' => @$data['invoice_number'] ? convert_arabic_number($data['invoice_number']) : @$data['invoice_number'],
            'amount' => @$data['amount'] ? convert_arabic_number($data['amount']) : @$data['amount']
        ]);
    }

    public function messages()
    {
        return [
            'invoice_number.unique' => trans('mobile.payments.is_paid_before'),
            'otp_code.required' => trans('mobile.otp.required'),
            'otp_code.exists' => trans('mobile.otp.exists'),
        ];
    }
}
