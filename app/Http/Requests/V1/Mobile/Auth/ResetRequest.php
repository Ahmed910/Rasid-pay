<?php

namespace App\Http\Requests\V1\Mobile\Auth;

use App\Http\Requests\ApiMasterRequest;

class ResetRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'identity_number' => 'required|numeric|digits_between:10,20|exists:users,identity_number',
        ];
    }
}
