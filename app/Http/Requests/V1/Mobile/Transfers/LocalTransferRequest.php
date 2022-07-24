<?php

namespace App\Http\Requests\V1\Mobile\Transfers;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Transfer;

class LocalTransferRequest extends ApiMasterRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            "otp_code" => 'required|exists:citizen_wallets,wallet_bin,citizen_id,' . auth()->id(),
            'amount'              => 'required|numeric|gte:' . (setting('rasidpay_localtransfer_minvalue') ?? 10) . '|lte:' . (setting('rasidpay_localtransfer_maxvalue') ?? 10000),
            'fee_upon' => 'required|in:' . join(',', Transfer::FEE_UPON),
            'transfer_purpose_id' => 'nullable|exists:transfer_purposes,id',
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'notes'               => 'nullable|required_without:transfer_purpose_id|max:1000'
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->all();

        $this->merge([
            'amount' => @$data['amount'] ? convert_arabic_number($data['amount']) : @$data['amount'],
        ]);
    }

    public function messages()
    {
        return [
            'otp_code.required' => trans('mobile.otp.required'),
            'otp_code.exists' => trans('mobile.otp.exists'),
        ];
    }
}
