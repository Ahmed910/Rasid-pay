<?php

namespace App\Http\Requests\V1\Dashboard\Auth;

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
          'username' => 'required',
          'password' => 'required',
          'device_token' => 'nullable|string|between:2,10000',
          'device_type' => 'nullable|in:ios,android',
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->all();

        $this->merge([
            'username' => @$data['username'] ? convert_arabic_number($data['username']) : null
        ]);
    }

}
