<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class CitizenRequest extends ApiMasterRequest
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

    protected function prepareForValidation()
    {
        $data = $this->all();

        $this->merge([
            'date_of_birth' => @$data['date_of_birth'] ? date('Y-m-d', strtotime($data['date_of_birth'])) : null,
            'country_code' => @$data['country_code'] ? convert_arabic_number($data['country_code']) : null,
            'phone' => @$data['phone'] ? filter_mobile_number($data['phone']) : @$data['phone']
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $list = countries_list();
        return [
            "fullname" => ["required", "max:100", "string"],
            "email" => ["nullable", "max:255", "email", "unique:users,email," . @$this->citizen],
            "image" => "nullable|max:5120|mimes:jpg,png,jpeg",
            "country_code" => "nullable|in:" . $list,
            "phone" => ["nullable", "numeric", "digits_between:7,20", "required_with:country_code", function ($attribute, $value, $fail) {
                if(!check_phone_valid($value)){
                    $fail(trans('mobile.validation.invalid_phone'));
                }
            }],
            "full_phone" => ["unique:users,phone," . @$this->client],
            "identity_number" => ["nullable", "numeric", "digits_between:10,20", "unique:users,identity_number," . @$this->citizen],
            "date_of_birth" => ["nullable", "date"],
            "location" => ["nullable", "string", "max:255"],
            "lng" => ["nullable", "string", "min:3", "max:255"],
            'lat' => ["nullable", "string", "min:3", "max:255"],
            "citizen_package_id" => "nullable|exists:citizen_packages,id"
        ];
    }
}
