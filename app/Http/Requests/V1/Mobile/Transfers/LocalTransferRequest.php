<?php

namespace App\Http\Requests\V1\Mobile\Transfers;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Transfer;
use App\Models\TransferPurpose\TransferPurpose;

class LocalTransferRequest extends ApiMasterRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $transferPurpose = TransferPurpose::find($this->transfer_purpose_id);
        $notes = 'nullable';

        if ($transferPurpose?->is_another) {
            $notes = 'required|string|max:1000';
        }

        return [
            "otp_code" => 'required|exists:citizen_wallets,wallet_bin,citizen_id,' . auth()->id(),
            "amount" => ['required', 'regex:/^\\d{1,7}$|^\\d{1,7}\\.\\d{0,2}$/', 'numeric', 'gte:' . (setting('rasidpay_localtransfer_minvalue') ?? 10) . '', 'lte:' . (setting('rasidpay_localtransfer_maxvalue') ?? 10000) . ''],
            'fee_upon' => 'required|in:' . join(',', Transfer::FEE_UPON),
            'transfer_purpose_id' => 'required|exists:transfer_purposes,id,is_active,1',
            'beneficiary_id' => 'required|exists:beneficiaries,id,benficiar_type,local',
            'notes'               => $notes
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
            'otp_code.required' => trans('mobile.validation.otp.required'),
            'otp_code.exists' => trans('mobile.validation.otp.exists'),
            'amount.required' => trans('validation.local_transfers.amount.required'),
            'amount.gte' => trans('validation.local_transfers.amount.gte', ['min_amount' => (setting('rasidpay_localtransfer_minvalue'))]),
            'amount.lte' => trans('validation.local_transfers.amount.lte', ['max_amount' => (setting('rasidpay_localtransfer_maxvalue'))]),
            'transfer_purpose_id.required' => trans('validation.local_transfers.transfer_purpose_id.required'),
            'transfer_purpose_id.exists' => trans('validation.local_transfers.transfer_purpose_id.exists'),
            'beneficiary_id.required' => trans('validation.local_transfers.beneficiary_id.required'),
            'beneficiary_id.exists' => trans('validation.local_transfers.beneficiary_id.exists'),
            'notes.required' => __('validation.local_transfers.notes.required'),


        ];
    }
}
