<?php

namespace App\Http\Requests\V1\Mobile\Auth;

use App\Http\Requests\ApiMasterRequest;

class CompleteRegisterRequest extends ApiMasterRequest
{

    public function rules()
    {
        return [
            'phone'    => ['required', 'string', 'digits_between:5,20', 'starts_with:9665,05', 'regex:/^(05|9665)([0-9]{8})$/', 'exits:users,phone'],
            'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        ];
    }
}
