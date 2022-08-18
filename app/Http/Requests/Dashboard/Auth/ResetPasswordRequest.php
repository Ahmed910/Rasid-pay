<?php

namespace App\Http\Requests\Dashboard\Auth;

use App\Http\Requests\ApiMasterRequest;
use App\Models\User;

class ResetPasswordRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = User::where(['reset_token'=>$this->_token])->first();
        if ($user && ($user->phone_verified_at || $user->email_verified_at)) {
            $code = 'required|exists:users,reset_code,deleted_at,NULL';
        }else{
            $code = 'required|exists:users,verified_code,deleted_at,NULL';
        }

        return [
            '_token' => 'required|exists:users,reset_token,ban_status,active',
            'password' => 'required|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/|min:8|max:100'
        ];
    }

    public function messages()
    {
        return [
            '_token.exists' =>  __('auth.token.not_exists'),
            'password.regex' => __('auth.reset_password.password.regex')
        ];
    }
}
