<?php

namespace App\Http\Requests\V1\Dashboard\Auth;

use App\Http\Requests\ApiMasterRequest;

class ResendCodeRequest extends ApiMasterRequest
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
            '_token' => 'required|exists:users,reset_token,ban_status,active',
            'code_type' => 'required|in:reset_code,verified_code,login_code',
        ];
    }

}
