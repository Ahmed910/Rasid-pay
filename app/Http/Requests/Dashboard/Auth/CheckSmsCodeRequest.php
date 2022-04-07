<?php

namespace App\Http\Requests\Dashboard\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class CheckSmsCodeRequest extends FormRequest
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
        $user = User::where(['reset_token'=>$this->reset_token])->first();
        if ($user && ($user->phone_verified_at || $user->email_verified_at)) {
            $code = 'required|min:4|exists:users,reset_code,deleted_at,NULL';
        }else{
            $code = 'required|exists:users,verified_code,deleted_at,NULL';
        }
        return [
            'reset_token' => 'required|exists:users,reset_token,ban_status,active',
            'reset_code' => $code
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->all();

        $this->merge([
            'reset_code' => @$data['reset_code'] ? implode('',array_reverse($data['reset_code'])) : null
        ]);
    }

    public function messages()
{
    return [
        'reset_code.exists' => trans('dashboard.general.invalid_code'),
    ];
}
}
