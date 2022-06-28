<?php

namespace App\Http\Requests\V1\Mobile\Auth;

use App\Http\Requests\ApiMasterRequest;

class CompleteRegisterRequest extends ApiMasterRequest
{

    public function rules()
    {
        return [
            'identity_number' => 'required|numeric|digits_between:10,20|exists:users,identity_number',
            'password' => 'required|min:8|max:20|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        ];
    }

    public function messages(){
        return [
            'password.min' => __('mobile.validation.password.min'),
            'password.max' => __('mobile.validation.password.max'),
            'password.regex' => __('mobile.validation.password.regex')
        ];
    }
}
