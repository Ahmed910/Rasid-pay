<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Transfer;

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
            "otp_code" => 'required|exists:citizen_wallets,wallet_bin,citizen_id,'.auth()->id(),
            'amount' => 'required|numeric|gte:'. (float)setting('min_local_transfer_amount') ?? 10,
            'fee_upon' => 'required|in:'.join(',', Transfer::FEE_UPON),
            'transfer_purpose_id' => 'nullable|exists:transfer_purposes,id',
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'notes'               => 'nullable|required_without:transfer_purpose_id|max:1000'
        ];
    }
}
