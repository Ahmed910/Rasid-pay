<?php

namespace App\Http\Requests\V1\Mobile\Auth;

use App\Http\Requests\ApiMasterRequest;

class CompleteRegisterRequest extends ApiMasterRequest
{

    public function rules()
    {
        return [
            'identity_number' => 'required|numeric|digits_between:10,20|unique:users,identity_number',
            'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        ];
    }
}
