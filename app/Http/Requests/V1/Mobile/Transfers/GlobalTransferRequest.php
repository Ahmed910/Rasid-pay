<?php

namespace App\Http\Requests\V1\Mobile\Transfers;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Transfer;

class GlobalTransferRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
           "otp_code" => 'required|exists:citizen_wallets,wallet_bin,citizen_id,'.auth()->id(),
            'amount'              => 'required|numeric|gte:'. (setting('min_global_transfer_amount') ?? 10) . '|lte:' . (setting('max_global_transfer_amount') ?? 10000),
//            'amount_transfer'     => 'required|numeric',
            'transfer_purpose_id' => 'nullable|exists:transfer_purposes,id',
            'currency_id'         => 'required|exists:countries,id',
            'to_currency_id'      => 'required|exists:countries,id',
            'fee_upon'            => 'required|in:'.join(',', Transfer::FEE_UPON),
            'beneficiary_id'      => 'nullable|exists:beneficiaries,id',
            'notes'               => 'nullable|required_without:transfer_purpose_id|max:1000'
        ];
    }

      
    public function messages()
    {
        return [
            'otp_code.required' =>  __('validation.global_transfers.otp_code.required'),
            'otp_code.exists' =>  __('validation.global_transfers.otp_code.exists'),
            'amount.required' =>  __('validation.global_transfers.amount.required'),
            'notes.required_without' =>  __('validation.global_transfers.notes.required_without'),
            'beneficiary_id.exists' =>  __('validation.global_transfers.beneficiary.exists'),
        ];
    }
}
