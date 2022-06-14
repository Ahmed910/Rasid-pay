<?php

namespace App\Http\Requests\V1\Mobile\Transfers;

use App\Http\Requests\ApiMasterRequest;
use App\Models\CitizenWallet;
use App\Models\Transfer;
use App\Models\User;

class WalletTransferRequest extends ApiMasterRequest
{
    private $user_object;
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
            "amount" => 'required|regex:/^\d{1,5}+(\.\d{1,2})?$/',
            "citizen_id" => 'nullable|exists:users,id,user_type,citizen',
            "otp_code" => 'required|exists:citizen_wallets,wallet_bin,citizen_id,'.auth()->id(),
            "transfer_status" => 'nullable|required_without:citizen_id|in:hold,transfered',
            "wallet_transfer_method" => 'required|in:' . join(",", Transfer::WALLET_TRANSFER_METHODS),
            "transfer_method_value" => ['required',function ($attribute, $value, $fail) {
                $message = $this->checkUserFound($this->wallet_transfer_method,$this->transfer_method_value);
                if(!is_bool($message)){
                    $fail($message);
                }
            }]
        ];
    }

    public function prepareForValidation()
    {
        $data = $this->all();

        return $this->merge([
            'citizen_id' => $this->user_object?->id,
        ]);
    }

    public function checkUserFound($key, $value)
    {
        switch ($key) {
            case 'wallet_number':
                $user = User::where('id',"<>",auth()->id())->whereRelation('citizenWallet', 'wallet_number', $value)->first();
                break;
            case 'identity_number':
                $user = User::where('id',"<>",auth()->id())->firstWhere(['user_type' => 'citizen', 'identity_number' => $value]);
                break;

            default:
                $user = User::where('id',"<>",auth()->id())->firstWhere(['user_type' => 'citizen', 'phone' => $value]);
                if (!$user) {
                    return $this->checkPhoneValid($value);
                }
                break;
        }
        $this->user_object = $user;
        return $user?->in_black_list ? trans('dashboard.citizen.wallet_in_black_list') : trans('validation.exists');
    }

    public function checkPhoneValid($phone)
    {
        return check_phone_valid($phone) ? true : trans('mobile.validation.invalid_phone');
    }


}
