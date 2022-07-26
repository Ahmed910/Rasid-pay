<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class ClientRequest extends ApiMasterRequest
{
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
            "country_code" => "nullable|in:" . $list,
            'phone' => ["nullable", function ($attribute, $value, $fail) {
                if (!check_phone_valid($value)) {
                    $fail(trans('mobile.validation.invalid_phone'));
                }
            }, 'unique:users,phone,' . @$this->client],
            "full_phone" => ["unique:users,phone," . @$this->client],
            "identity_number" => ["nullable", "numeric", "digits_between:10,20", "unique:users,identity_number," . @$this->client],
            "client_type" => ["required", "in:company,institution,member,freelance_doc,famous,other"],
            "gender" => ["nullable", "in:male,female"],
            "date_of_birth" => ["nullable", "date"],
            "commercial_number" => ["nullable", "required_if:client_type,company,institution", "string", "max:10", "unique:clients,commercial_number," . @$this->client . ",user_id"],
            "tax_number" => "required|max:15|string|unique:clients,tax_number," . @$this->client . ",user_id",
            "register_type" => ["required_if:client_type,company,institution", "in:delegate,direct"],
            "activity_type" => ["nullable", "string", "max:100"],
            "daily_expect_trans" => ["required", "numeric", "digits_between:1,15"],
            "address" => ["nullable", "string", "max:255"],
            "nationality" => ["nullable", "string", "max:255", "min:2"],
            "marital_status" => ["nullable", "in:married,single"],
        ];
    }
}
