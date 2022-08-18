<?php

namespace App\Http\Requests\Mobile\Transfers;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Transfer;
use App\Models\TransferPurpose\TransferPurpose;

class GlobalTransferRequest extends ApiMasterRequest
{
    public function rules()
    {
        $transferPurpose = TransferPurpose::find($this->transfer_purpose_id);
        $notes = 'nullable';

        if ($transferPurpose?->is_another) {
            $notes = 'required|string|max:1000';
        }

        return [
            "otp_code" => 'required|exists:citizen_wallets,wallet_bin,citizen_id,' . auth()->id(),
            "amount" => ['required', 'regex:/^\\d{1,7}$|^\\d{1,7}\\.\\d{0,2}$/', 'numeric', 'gte:'. (setting('rasidpay_inttransfer_minvalue') ?? 10).'', 'lte:'. (setting('rasidpay_inttransfer_maxvalue')??10000).''],
            //            'amount_transfer'     => 'required|numeric',
            'transfer_purpose_id' => 'required|exists:transfer_purposes,id,is_active,1',
            'currency_id' => 'required|exists:countries,id',
            'to_currency_id' => 'required|exists:countries,id',
            'fee_upon' => 'required|in:' . join(',', Transfer::FEE_UPON),
            'beneficiary_id' => 'nullable|exists:beneficiaries,id,benficiar_type,global',
            'notes' => $notes
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
            'otp_code.required' => __('validation.global_transfers.otp_code.required'),
            'otp_code.exists' => __('validation.global_transfers.otp_code.exists'),
            'amount.required' => __('validation.global_transfers.amount.required'),
            'amount.gte' => trans('validation.global_transfers.amount.gte', ['min_amount' => (setting('rasidpay_inttransfer_minvalue'))]),
            'amount.lte' => trans('validation.global_transfers.amount.lte', ['max_amount' => (setting('rasidpay_inttransfer_maxvalue'))]),
            'notes.required' => __('validation.global_transfers.notes.required'),
            'beneficiary_id.exists' => __('validation.global_transfers.beneficiary.exists'),
            'transfer_purpose_id.required' => trans('validation.global_transfers.transfer_purpose.required'),
            'transfer_purpose_id.exists' => trans('validation.global_transfers.transfer_purpose.exists'),

        ];
    }
}
