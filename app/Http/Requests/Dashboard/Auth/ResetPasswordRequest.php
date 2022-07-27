<?php

namespace App\Http\Requests\Dashboard\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'reset_token'           => 'required|exists:users,reset_token,ban_status,active',
            'password'              => 'required|confirmed|regex:/^[A-Za-z0-9()\]\[#%&*_=~{}^:`.,$!@+\/-]+$/|min:6|max:100',
            'password_confirmation' => 'required|same:password',
        ];
    }

}
