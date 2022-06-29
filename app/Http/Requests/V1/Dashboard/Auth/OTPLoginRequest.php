<?php

namespace App\Http\Requests\V1\Dashboard\Auth;

use App\Http\Requests\ApiMasterRequest;

class OTPLoginRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            '_token' => 'required|exists:users,reset_token,ban_status,active',
            'code' => 'required|exists:users,login_code,ban_status,active',
            'device_token' => 'nullable|string|between:2,10000',
            'device_type' => 'nullable|in:ios,android',
        ];
    }
}
