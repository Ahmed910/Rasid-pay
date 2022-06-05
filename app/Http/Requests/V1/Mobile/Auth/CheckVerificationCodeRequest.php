<?php

namespace App\Http\Requests\V1\Mobile\Auth;

use App\Http\Requests\ApiMasterRequest;
use App\Models\User;

class CheckVerificationCodeRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'phone'     => 'required|numeric|digits_between:5,20',
            'code'      => 'required|exists:users,' . $this->key_name . ',phone,' . $this->phone,
        ];
    }

    public function prepareForValidation()
    {
        $data = $this->all();
        $keyName = 'verified_code';
        $phone = @$data['phone'] ? convert_arabic_number($data['phone']) : @$data['phone'];
        $user = User::firstWhere(['phone' => $phone , 'user_type' => 'citizen']);
        if ($user && ($user->phone_verified_at || $user->email_verified_at)) {
            $keyName = 'reset_code';
        }

        return $this->merge([
            'key_name' => $keyName,
            'phone' => $phone
        ]);
    }
}
