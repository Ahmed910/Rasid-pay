<?php

namespace App\Http\Requests\V1\Mobile\Auth;

use App\Http\Requests\ApiMasterRequest;

class RegisterRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'identity_number' => 'required|numeric|digits:10|regex:/^[1-9][0-9]*$/|unique:users,identity_number,NULL,uuid,register_status,completed',
            'phone' => ["required", "numeric", "digits_between:9,20", 'starts_with:9665,05', 'unique:users,phone,NULL,uuid,register_status,completed', function ($attribute, $value, $fail) {
                if (!check_phone_valid($value)) {
                    $fail(trans('mobile.validation.invalid_phone'));
                }
            }, 'unique:users,phone,NULL,uuid,register_status,completed'],
            'date_of_birth' => 'required|date_format:Y-m-d|after_or_equal:1920-01-01|before_or_equal:today',
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

    public function messages(): array
    {
        return [
            'phone.unique' => trans('mobile.validation.unique_phone'),
            'date_of_birth.before' => trans('mobile.validation.before'),
            'phone.digits_between' => trans('mobile.validation.phone_digits'),
        ];
    }
}
