<?php

namespace App\Http\Requests\V1\Mobile\Auth;

use App\Http\Requests\ApiMasterRequest;

class LoginRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'identity_number' => 'required|numeric|regex:/^[1-9][0-9]*$/',
          'password' => 'required',
          'device_token' => 'nullable|string|between:2,1000',
          'device_type' => 'nullable|in:ios,android',
        ];
    }

}
