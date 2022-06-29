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
            "otp_code" => 'required|exists:citizen_wallets,wallet_bin,citizen_id,'.auth()->id(),
            'amount'              => 'required|numeric|gte:'. setting('min_local_transfer_amount') ?? 10 . '|lte:' . setting('max_local_transfer_amount') ?? 10000,
            'fee_upon' => 'required|in:'.join(',', Transfer::FEE_UPON),
            'transfer_purpose_id' => 'nullable|exists:transfer_purposes,id',
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'notes'               => 'nullable|required_without:transfer_purpose_id|max:1000'
        ];
    }
}
