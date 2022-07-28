<?php

namespace App\Http\Requests\V1\Dashboard\Auth;

use App\Http\Requests\ApiMasterRequest;

class SendCodeRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = ['send_type' => 'required|in:email,phone'];
        if($this->send_type == 'email'){
            $rules['username'] = 'required|email|exists:users,email,deleted_at,NULL';
        }elseif($this->send_type == 'phone'){
            $rules['username'] = ["required",function ($attribute, $value, $fail) {
                if (!check_phone_valid($value)) {
                    $fail(trans('auth.phone.invalid_phone'));
                }
            },"exists:users,phone,deleted_at,NULL"];
        }
        return $rules;
    }

    protected function prepareForValidation()
    {
        $data = $this->all();

        $this->merge([
            'username' => @$data['username'] && is_numeric($data['username']) ? convert_arabic_number($data['username']) : @$data['username']
        ]);
    }

    public function messages()
    {
        if($this->send_type == 'email'){
            return [
                'username.exists' => trans('validation.custom.email.exists'),
                'username.email' =>  trans('validation.custom.email.correct_email')
            ];
        } elseif($this->send_type == 'phone'){
            return [
                'username.exists'  =>  trans('auth.phone.phone_not_registered'),
                'username.numeric' => trans('auth.phone.invalid_phone')
            ];
        } else {
            return [
                'send_type.in'  => trans('auth.reset_password.invalid_method'),
            ];
        }
    }
}

