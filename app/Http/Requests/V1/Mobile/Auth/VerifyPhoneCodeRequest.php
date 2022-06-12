<?php

namespace App\Http\Requests\V1\Mobile\Auth;

use App\Http\Requests\ApiMasterRequest;
use App\Models\User;

class VerifyPhoneCodeRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'identity_number'     => 'required|numeric|digits_between:10,20',
            'code'      => 'required|exists:users,' . $this->key_name . ',identity_number,' . $this->identity_number,
        ];
    }

    public function prepareForValidation()
    {
        $data = $this->all();
        $keyName = 'verified_code';
        $identity_number = @$data['identity_number'] ? convert_arabic_number($data['identity_number']) : @$data['identity_number'];
        $user = User::firstWhere(['identity_number' => $identity_number , 'user_type' => 'citizen']);
        if ($user && ($user->phone_verified_at || $user->email_verified_at)) {
            $keyName = 'reset_code';
        }

        return $this->merge([
            'key_name' => $keyName,
            'identity_number' => $identity_number
        ]);
    }
}
