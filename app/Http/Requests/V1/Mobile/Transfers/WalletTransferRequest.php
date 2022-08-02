<?php

namespace App\Http\Requests\V1\Mobile\Transfers;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Transfer;
use App\Models\TransferPurpose\TransferPurpose;
use App\Models\User;

class WalletTransferRequest extends ApiMasterRequest
{
    public function rules()
    {
        $transferPurpose = TransferPurpose::find($this->transfer_purpose_id);
        $notes = 'nullable';

        if ($transferPurpose->is_another) {
            $notes = 'required|string|max:1000';
        }

        return [
            "amount" => ['required', 'regex:/^\\d{1,7}$|^\\d{1,7}\\.\\d{0,2}$/', 'numeric', 'gte:' . (setting('rasidpay_wallettransfer_minvalue') ?? 10) . '', 'lte:' . (setting('rasidpay_wallettransfer_maxvalue') ?? 10000) . ''],
            "wallet_transfer_method" => 'required|in:' . join(",", Transfer::WALLET_TRANSFER_METHODS),
            'notes'   => $notes,
            "transfer_method_value" => ['required', function ($attribute, $value, $fail) {
                if (!is_bool($this->message)) {
                    $fail($this->message);
                }
            }],
            'transfer_purpose_id' => 'required|exists:transfer_purposes,id',
            "otp_code" => 'required|exists:citizen_wallets,wallet_bin,citizen_id,' . auth()->id(),
            "citizen_id" => 'nullable|exists:users,id,user_type,citizen,register_status,completed',
        ];
    }

    public function prepareForValidation()
    {
        $data = $this->all();
        $this->message = $this->checkUserFound($this->wallet_transfer_method, $this->transfer_method_value);

        return $this->merge([
            'amount' => @$data['amount'] ? convert_arabic_number($data['amount']) : @$data['amount'],
            'citizen_id' => $this->user_object?->id,
        ]);
    }

    public function checkUserFound($key, $value)
    {
        $value = filter_mobile_number($value);
        $sameUser = User::where(['id' => auth()->id(), 'user_type' => 'citizen'])->where(function ($q) use ($value) {
            $q->where('identity_number', $value)->orWhereRelation('citizenWallet', 'wallet_number', $value);
        })->first();

        if ($sameUser) {
            return trans('mobile.validation.not_same_wallet');
        }

        switch ($key) {
            case Transfer::WALLET_NUMBER:
                $user = User::where('id', "<>", auth()->id())->whereRelation('citizenWallet', 'wallet_number', $value)->first();
                if (!$user) {
                    return trans('mobile.validation.wallet_number_is_not_found');
                }
                break;
            case Transfer::IDENTITY_NUMBER:
                if (!preg_match('/^[1-9][0-9]*$/', $value)) {
                    return trans('validation.custom.identity_number.regex');
                }
                $user = User::where('id', "<>", auth()->id())->firstWhere(['user_type' => 'citizen', 'identity_number' => $value]);
                if (!$user) {
                    return trans('mobile.validation.identity_number.is_not_found');
                }
                break;

            default:
                $check_phone = $this->checkPhoneValid($value);
                if (is_string($check_phone)) {
                    return $check_phone;
                }
                $user = User::firstWhere(['user_type' => 'citizen', 'phone' => $value]);
                if ($user?->id == auth()->id()) {
                    return trans('mobile.validation.not_same_wallet');
                }
                // if (!$user) {
                //     return trans('mobile.validation.phone.is_not_found');
                // }

                break;
        }
        return $this->checkBlackList($user);
    }

    private function checkPhoneValid($phone)
    {
        return check_phone_valid($phone) ? true : trans('mobile.validation.phone.invalid');
    }

    private function checkBlackList($user)
    {
        $this->user_object = $user;
        if ($user?->in_black_list || $user->ban_status != 'active') {
            return trans('dashboard.citizen.wallet_in_black_list');
        } elseif (!$user) {

            return trans('validation.exists');
        }
        return true;
    }

    public function messages()
    {
        return [
            'otp_code.required' => trans('mobile.validation.otp.required'),
            'otp_code.exists' => trans('mobile.validation.otp.exists'),
            'transfer_purpose_id.exists' => trans('mobile.wallet_transfer.transfer_purpose.exists'),
            'amount.gte' => trans('validation.wallet_transfer.amount.gte', ['min_amount' => (setting('rasidpay_wallettransfer_minvalue'))]),
            'amount.lte' => trans('validation.wallet_transfer.amount.lte', ['max_amount' => (setting('rasidpay_wallettransfer_maxvalue'))]),


        ];
    }
}
