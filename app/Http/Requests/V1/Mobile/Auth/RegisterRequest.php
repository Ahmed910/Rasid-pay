<?php

namespace App\Http\Requests\V1\Mobile\Auth;

use App\Http\Requests\ApiMasterRequest;

class RegisterRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'identity_number' => 'required|numeric|digits_between:10,20|unique:users,identity_number,NULL,uuid,register_status,completed',
            'phone' => ["required", "numeric", "digits_between:7,20", 'starts_with:9665,05', function ($attribute, $value, $fail) {
                if(!check_phone_valid($value)){
                    $fail(trans('mobile.validation.invalid_phone'));
                }
            }, 'unique:users,phone,NULL,uuid,register_status,completed'],
            'date_of_birth'   => 'required|date_format:Y-m-d|after_or_equal:1920-01-01|before:today',
            'image' => 'nullable|max:5120|mimes:jpg,png,jpeg',
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->all();

        $this->merge([
            'phone' => @$data['phone'] ? convert_arabic_number($data['phone']) : $data['phone']
        ]);
    }
}
