<?php

namespace App\Http\Requests\V1\Dashboard\Auth;

use App\Http\Requests\ApiMasterRequest;

class ResetPasswordRequest extends ApiMasterRequest
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
        $user = User::where(['phone'=>$this->phone])->first();
        if ($user && ($user->phone_verified_at || $user->email_verified_at)) {
            $code = 'required|exists:users,reset_code';
        }else{
            $code = 'required|exists:users,verified_code';
        }

        return [
            'phone' => 'required|exists:users,phone',
            'code' => $code,
            'password' => 'required|min:6'
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
