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
        $this->phone = convert_arabic_number($this->phone);
//        isset( $this->phone[0])
        $forvalidation = isset($this->phone[0]) && $this->phone[0] == "0" ? substr($this->phone, 1) : $this->phone;
        $this->merge([
            'date_of_birth' => @$data['date_of_birth'] ? date('Y-m-d', strtotime($data['date_of_birth'])) : null,
            'country_code' => @$data['country_code'] ? convert_arabic_number($data['country_code']) : null,
            'phone' => @$data['phone'] ? convert_arabic_number($data['phone']) : null,
            'full_phone' => $this->country_code . $forvalidation
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
            "email" => ["nullable", "max:255", "email", "unique:users,email," . @$this->client],
            "image"         => "nullable|max:5120|mimes:jpg,png,jpeg",
            "country_code" => "nullable|in:" . $list,
            "phone" => ["nullable", "not_regex:/^{$this->country_code}/", "numeric", "digits_between:7,20"],
            "full_phone" => ["unique:users,phone," . @$this->client],
            "identity_number" => ["nullable", "numeric", "digits_between:10,20", "unique:users,identity_number," . @$this->citizen],
            "date_of_birth" => ["nullable", "date"],
            "location" => ["nullable", "string", "max:255"],
            "lng" => ["required","numeric","between:-180,180"],
            'lat' => ["required","numeric","between:-90,90"],
        ];
    }
}
