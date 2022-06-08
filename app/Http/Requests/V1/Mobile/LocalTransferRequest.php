<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;

class LocalTransferRequest extends ApiMasterRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'balance_type'=>'required|in:pay,back',
            'amount'=>'required|numeric',
            'transfer_fees'=>'nullable|numeric',
            'transfer_purpose_id'=>'required|exists:transfer_purposes,id',
            'beneficiary_id'=>'required|exists:beneficiaries,id',
        ];
    }
}
