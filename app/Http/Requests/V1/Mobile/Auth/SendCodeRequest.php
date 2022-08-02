<?php

namespace App\Http\Requests\V1\Mobile\Auth;

use App\Http\Requests\ApiMasterRequest;
use App\Models\User;

class SendCodeRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'identity_number' => 'required|numeric|regex:/^[1-9][0-9]*$/|digits:10|exists:users,identity_number',
            'key_name' => 'required|in:verified_code,reset_code'
        ];
    }

    public function prepareForValidation()
    {
        $data = $this->all();
        $keyName = 'verified_code';
        $identity_number = @$data['identity_number'] ? convert_arabic_number($data['identity_number']) : @$data['identity_number'];
        $user = User::firstWhere(['identity_number' => $identity_number , 'user_type' => 'citizen']);
        if ($user && $user->phone_verified_at && $user->password) {
            $keyName = 'reset_code';
        }

        return $this->merge([
            'key_name' => $keyName,
        ]);
    }

    public function messages(){
        return [
            "identity_number.required"  => __('mobile.validation.identity_number.required'),
            "identity_number.digits"     => __('mobile.validation.identity_number.digits'),
            "identity_number.exists"     => __('mobile.validation.identity_number.not_exists'),
        ];
    }
}
