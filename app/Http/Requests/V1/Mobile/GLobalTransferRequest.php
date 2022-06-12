<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;

class GLobalTransferRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'balance_type'        => 'required|in:back,pay',
            'amount'              => 'required|numeric',
            'amount_transfer'     => 'required|numeric',
            'transfer_purpose_id' => 'required|exists:transfer_purposes,id',
            'currency_id'         => 'required|exists:currencies,id',
            'to_currency_id'      => 'required|exists:currencies,id',
            'transfer_fees'       => 'required|numeric',
            'fee_upon'            => 'required|in:from_user,to_user',
            'beneficiary_id'      => 'required|exists:beneficiaries,id',
        ];
    }
}
