<?php

namespace App\Http\Requests\Mobile;

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
            'balance_type' => 'required|in:main,back',
            'amount' => 'required|numeric|gte:'. (float)setting('min_local_transfer_amount') ?? 10,
            'fee_upon' => 'required|in:'.join(',', Transfer::FEE_UPON),
            'transfer_purpose_id' => 'required|exists:transfer_purposes,id',
            'beneficiary_id' => 'required|exists:beneficiaries,id',
        ];
    }
}
