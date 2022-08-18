<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class EmployeeRequest extends ApiMasterRequest
{
    protected function prepareForValidation()
    {
        $data = $this->all();
        $this->merge([
            'date_of_birth' =>  @$data['date_of_birth'] ? date('Y-m-d', strtotime($data['date_of_birth'])) : null,
            'date_of_birth_hijri' =>  @$data['date_of_birth_hijri'] ? date('Y-m-d', strtotime($data['date_of_birth_hijri'])) : null,
            'phone' => @$data['phone'] ? filter_mobile_number($data['phone']) : @$data['phone'],
            'whatsapp' => @$data['whatsapp'] ? filter_mobile_number($data['whatsapp']) : @$data['whatsapp']
        ]);
    }

    public function rules()
    {
        return [
            'fullname' => 'required|string|max:225|min:2',
            'email' => 'required|email|max:225|unique:users,email,' . @$this->employee,
            'identity_number' => 'required|numeric|digits_between:10,20|unique:users,identity_number,' . @$this->employee,
            'phone' => ["required", "numeric", function ($attribute, $value, $fail) {
                if (!check_phone_valid($value)) {
                    $fail(trans('mobile.validation.phone.invalid'));
                }
            }, 'unique:users,phone,' . @$this->employee],
            'whatsapp' => ["required", "numeric", function ($attribute, $value, $fail) {
                if (!check_phone_valid($value)) {
                    $fail(trans('mobile.validation.phone.invalid'));
                }
            }, 'unique:users,whatsapp,' . @$this->employee],
            'gender' => 'required|in:male,female',
            "contract_type" => 'required|in:salary,salary_with_percent,percent',
            'salary' => 'required|numeric|digits_between:1,10',
            'department_id' => 'required|exists:departments,id,deleted_at,NULL',
            'rasid_job_id' => 'required|exists:rasid_jobs,id,deleted_at,NULL,is_vacant,1,department_id,'.$this->department_id,
            'ban_status' => 'required|in:active,permanent,temporary',
            "ban_from" => 'required_if:ban_status,temporary|date',
            "ban_to" => 'required_if:ban_status,temporary|date|after_or_equal:ban_from',
            'date_of_birth' => 'required|date',
            'image' => 'mimes:jpg,jpeg,png,webp|max:5120',
        ];
    }

}
