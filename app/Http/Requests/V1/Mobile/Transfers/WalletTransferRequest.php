<?php

namespace App\Http\Requests\V1\Mobile\Transfers;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Transfer;
use App\Models\User;

class WalletTransferRequest extends ApiMasterRequest
{
    private $user_object;
    private $message;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // if (!$this->citizen_id && $this->wallet_transfer_method == 'phone') {
        //     $data = [
        //         "transfer_status" => 'required|in:hold,transfered'
        //     ];
        // }
        return [
            'amount'  => 'required|numeric|gte:'. (setting('min_wallet_transfer_amount') ?? 10) . '|lte:' . (setting('max_wallet_transfer_amount') ?? 10000),
            "citizen_id" => 'nullable|exists:users,id,user_type,citizen,register_status,completed',
            "otp_code" => 'required|exists:citizen_wallets,wallet_bin,citizen_id,'.auth()->id(),
            "wallet_transfer_method" => 'required|in:' . join(",", Transfer::WALLET_TRANSFER_METHODS),
            'transfer_purpose_id' => 'nullable|exists:transfer_purposes,id',
            'notes'   => 'nullable|required_without:transfer_purpose_id|max:1000',
            "transfer_method_value" => ['required',function ($attribute, $value, $fail) {
                if(!is_bool($this->message)){
                    $fail($this->message);
                }
            }]
        ];
    }

    public function prepareForValidation()
    {
        $data = $this->all();
        $this->message = $this->checkUserFound($this->wallet_transfer_method,$this->transfer_method_value);
        return $this->merge([
            'citizen_id' => $this->user_object?->id,
        ]);
    }

    public function checkUserFound($key, $value)
    {
        switch ($key) {
            case Transfer::WALLET_NUMBER:
                $user = User::where('id',"<>",auth()->id())->whereRelation('citizenWallet', 'wallet_number', $value)->first();
                break;
            case Transfer::IDENTITY_NUMBER:
                $user = User::where('id',"<>",auth()->id())->firstWhere(['user_type' => 'citizen', 'identity_number' => $value]);
                break;

            default:
                $user = User::where('id',"<>",auth()->id())->firstWhere(['user_type' => 'citizen', 'phone' => $value]);
                if (!$user) {
                    return $this->checkPhoneValid($value);
                }
                break;
        }
        return $this->checkBlackList($user);
    }

    private function checkPhoneValid($phone)
    {
        return check_phone_valid($phone) ? true : trans('mobile.validation.invalid_phone');
    }

    private function checkBlackList($user)
    {
        $this->user_object = $user;
        if ($user?->in_black_list) {
            return trans('dashboard.citizen.wallet_in_black_list');
        }elseif (!$user) {
            return trans('validation.exists');
        }
        return true;
    }


}
