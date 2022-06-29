<?php

namespace App\Http\Requests\V1\Dashboard\Auth;

use App\Http\Requests\ApiMasterRequest;

class LogoutRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'device_token' => 'nullable|exists:devices,device_token',
            'device_type' => 'nullable|exists:devices,device_type',
        ];

    }

}
