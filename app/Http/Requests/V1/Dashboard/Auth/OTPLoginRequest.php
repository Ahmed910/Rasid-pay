<?php

namespace App\Http\Requests\V1\Dashboard\Auth;

use App\Http\Requests\ApiMasterRequest;

class OTPLoginRequest extends ApiMasterRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'required',
            'code' => 'required|exists:users,login_code,ban_status,active',
            'device_token' => 'nullable|string|between:2,10000',
            'device_type' => 'nullable|in:ios,android',
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->all();

        $this->merge([
            'phone' => @$data['phone'] ? convert_arabic_number($data['phone']) : null
        ]);
    }

}
