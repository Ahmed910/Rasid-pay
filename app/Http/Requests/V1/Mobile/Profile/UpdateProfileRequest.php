<?php

namespace App\Http\Requests\V1\Mobile\Profile;

use App\Http\Requests\ApiMasterRequest;

class UpdateProfileRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'nullable|max:5120|mimes:jpg,png,jpeg',
            // 'fullname' => 'required|string|max:100',
            'phone' => ["required", "numeric", 'starts_with:9665,05', "digits_between:9,20", function ($attribute, $value, $fail) {
                if (!check_phone_valid($value)) {
                    $fail(trans('mobile.validation.invalid_phone'));
                }
            }, 'unique:users,phone,' . auth()->id()],
            // 'whatsapp' => 'nullable|starts_with:9665,05|unique:users,whatsapp,' . auth()->id(),
            // 'identity_number' => 'required|numeric|digits_between:10,20|unique:users,identity_number,' . auth()->id(),
            // 'email' => 'nullable|email|unique:users,email,' . auth()->id(),
            'lat' => 'nullable|string|max:15',
            'lng' => 'nullable|string|max:15',
            'location' => 'nullable|string|between:3,100',
            'device_token' => 'nullable|string|between:2,1000',
            'device_type' => 'nullable|in:ios,android',
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->all();
        $this->merge([
            'phone' => @$data['phone'] ? convert_arabic_number($data['phone']) : @$data['phone']
        ]);
    }
}
