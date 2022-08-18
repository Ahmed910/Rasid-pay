<?php

namespace App\Http\Requests\Dashboard\Auth;

use App\Http\Requests\ApiMasterRequest;

class ResendCodeRequest extends ApiMasterRequest
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
            'code_type' => 'required|in:reset_code,verified_code,login_code',
        ];
    }

    public function messages()
    {
        return [
            '_token.exists' =>  __('auth.token.not_exists')
        ];
    }

}
