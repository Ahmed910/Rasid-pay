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
            'image' => 'nullable|max:1024|mimes:jpg,png,jpeg',
            // 'fullname' => 'required|string|max:100',
            'phone' => ["required", "numeric", function ($attribute, $value, $fail) {
                if (!check_phone_valid($value)) {
                    $fail(trans('mobile.validation.phone.invalid'));
                }
            }, 'unique:users,phone,' . auth()->id()],
            'lat' => 'nullable|string|max:15',
            'lng' => 'nullable|string|max:15',
            'location' => 'nullable|string|between:3,100'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => filter_mobile_number($this->phone)
        ]);
    }

    public function messages()
    {
        return [
            'image.max' =>  __('mobile.profile.validation.max_image_size'),
            'image.mimes' =>  __('mobile.profile.validation.image_mimes'),
            'phone.required' =>  __('mobile.profile.validation.phone_required'),
            'phone.unique' =>  __('mobile.profile.validation.phone_unique'),
        ];
    }
}
