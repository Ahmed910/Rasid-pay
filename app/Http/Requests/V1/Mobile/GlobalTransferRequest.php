<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Transfer;

class GlobalTransferRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'balance_type'        => 'required|in:back,main',
            'amount'              => 'required|numeric|gte:'. (float)setting('min_global_transfer_amount') ?? 10,
            'amount_transfer'     => 'required|numeric',
            'transfer_purpose_id' => 'required|exists:transfer_purposes,id',
            'currency_id'         => 'required|exists:currencies,id',
            'to_currency_id'      => 'required|exists:currencies,id',
            'transfer_fees'       => 'required|numeric',
            'fee_upon'            => 'required|in:'.join(',', Transfer::FEE_UPON),
            'beneficiary_id'      => 'required|exists:beneficiaries,id',
        ];
    }
}
