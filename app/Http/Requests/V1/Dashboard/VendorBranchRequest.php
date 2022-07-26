<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class VendorBranchRequest extends ApiMasterRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $vendor_branch = $this->vendor_branch ? $this->vendor_branch : null;
        $rules = [
            'vendor_id' => 'required|exists:vendors,id',
            'location' => 'required|string|between:3,250',
            'address_details' => 'required|string|between:3,250',
            'logo' => 'nullable|max:5120|mimes:jpg,png,jpeg,gif',
            'email' => 'required|email',
            "phone" => ["required", "numeric", function ($attribute, $value, $fail) {
                if (!check_phone_valid($value)) {
                    $fail(trans('mobile.validation.invalid_phone'));
                }
            }],
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ];
        if (isset($vendor_branch) && $vendor_branch) {
            $rules['is_active'] = 'required|in:0,1';
        }
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = "required|string|between:2,200";
        }
        // dd($rules);

        return $rules;
    }

    public function messages()
    {
        $validation = 'dashboard.vendor_branch.validation';

        $validation_messages = [
            'vendor_id.required' => trans($validation . '.vendor_id.required'),
            'vendor_id.exists' => trans($validation . '.vendor_id.exists'),
            'location.required' => trans($validation . '.location.required'),
            'location.string' => trans($validation . '.location.string'),
            'location.between' => trans($validation . '.location.between'),
            'address_details.required' => trans($validation . '.address_details.required'),
            'address_details.string' => trans($validation . '.address_details.string'),
            'address_details.between' => trans($validation . '.address_details.between'),
            'lat.required' => trans($validation . '.lat.required'),
            'lat.numeric' => trans($validation . '.lat.numeric'),
            'lng.required' => trans($validation . '.lng.required'),
            'lng.numeric' => trans($validation . '.lng.numeric'),
            'logo.required' => trans($validation . '.logo.required'),
            'logo.image' => trans($validation . '.logo.image'),
            'logo.mimes' => trans($validation . '.logo.mimes'),
            'logo.max' => trans($validation . '.logo.max'),
            'email.required' => trans($validation . '.email.required'),
            'email.email' => trans($validation . '.email.email'),
            'email.unique' => trans($validation . '.email.unique'),
            'phone.required' => trans($validation . '.phone.required'),
            'phone.numeric' => trans($validation . '.phone.numeric'),
            'phone.digits_between' => trans($validation . '.phone.digits_between'),
            'phone.starts_with' => trans($validation . '.phone.starts_with'),
            'phone.unique' => trans($validation . '.phone.unique'),
            'is_active.required' => trans($validation . '.is_active.required'),
            'is_active.in' => trans($validation . '.is_active.in'),
        ];
        foreach (config('translatable.locales') as $locale) {
            $validation_messages["$locale.name.required"] = trans("$validation.$locale.name.required");
            $validation_messages["$locale.name.string"] = trans("$validation.$locale.name.string");
            $validation_messages["$locale.name.between"] = trans("$validation.$locale.name.between");
        }


        return $validation_messages;
    }
}
