<?php

namespace App\Http\Requests\V1\Mobile\Transfers;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Transfer;
use App\Models\TransferPurpose\TransferPurpose;

class GlobalTransferRequest extends ApiMasterRequest
{
    public function rules()
    {
        $transferPurpose = TransferPurpose::find($this->transfer_purpose_id);
        $notes = 'nullable';

        if ($transferPurpose->is_another) {
            $notes = 'required|string|max:1000';
        }

        return [
            "otp_code" => 'required|exists:citizen_wallets,wallet_bin,citizen_id,' . auth()->id(),
            'amount'              => 'required|numeric|gte:' . (setting('min_global_transfer_amount') ?? 10) . '|lte:' . (setting('max_global_transfer_amount') ?? 10000),
            //            'amount_transfer'     => 'required|numeric',
            'transfer_purpose_id' => 'required|exists:transfer_purposes,id',
            'currency_id'         => 'required|exists:countries,id',
            'to_currency_id'      => 'required|exists:countries,id',
            'fee_upon'            => 'required|in:' . join(',', Transfer::FEE_UPON),
            'beneficiary_id'      => 'nullable|exists:beneficiaries,id',
            'notes'               => $notes
        ];
    }
}
