<?php

namespace App\Http\Requests\Mobile\Auth;

use App\Http\Requests\ApiMasterRequest;

class ResetPasswordRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'identity_number' => 'required|numeric|digits_between:10,20|exists:users,identity_number',
            'password'        => 'required|min:8|max:20|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'reset_code'   => 'required|exists:users,reset_code,identity_number,'.$this->identity_number
        ];
    }

    public function messages(){
        return [
            'reset_code.required' => __('mobile.validation.reset_code.required'),
            'reset_code.exists'   => __('mobile.validation.reset_code.exists'),
            'password.min'      => __('mobile.validation.password.min'),
            'password.max'      => __('mobile.validation.password.max'),
            'password.regex'    => __('mobile.validation.password.regex'),
        ];
    }

}
