<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class ProfileRequest extends ApiMasterRequest
{

    public function rules()
    {

        return [
            // 'fullname' => 'required|string|max:225',
            // 'email' => 'required|email|max:225|unique:users,email,' . auth()->id(),
            // 'phone' => ["required", "numeric", function ($attribute, $value, $fail) {
            //     if (!check_phone_valid($value)) {
            //         $fail(trans('mobile.validation.phone.invalid'));
            //     }
            // }, 'unique:users,phone,' . auth()->id()],
            // 'whatsapp' => ["required", "numeric", function ($attribute, $value, $fail) {
            //     if (!check_phone_valid($value)) {
            //         $fail(trans('mobile.validation.phone.invalid'));
            //     }
            // }, 'unique:users,whatsapp,' . auth()->id()],
            // 'identity_number' => 'required|digits:10|unique:users,identity_number,' . auth()->id(),
            // 'gender' => 'required|in:male,female',
            // 'date_of_birth' => 'required|date',
            // 'date_of_birth_hijri' => 'required|date',
            // 'is_date_hijri' => 'boolean'
            "image" =>  'nullable|image|max:5120',
            'current_password' => [
                'required_with:password',
                'min:6',
                'max:20',
                function ($attribute, $value, $fail) {
                    if (!\Hash::check($value, auth()->user()->password)) {
                        $fail(trans('auth.wrong_old_password'));
                    }
                }
            ],
            'password' => 'required_with:current_password|min:8|max:20|different:current_password|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->all();
        $this->merge([
            'phone' => @$data['phone'] ? filter_mobile_number($data['phone']) : @$data['phone'],
            'whatsapp' => @$data['whatsapp'] ? filter_mobile_number($data['whatsapp']) : @$data['whatsapp']
        ]);
    }
}
