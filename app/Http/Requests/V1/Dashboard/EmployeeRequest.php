<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class EmployeeRequest extends ApiMasterRequest
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
            'date_of_birth' =>  @$data['date_of_birth'] ? date('Y-m-d', strtotime($data['date_of_birth'])) : null,
            'date_of_birth_hijri' =>  @$data['date_of_birth_hijri'] ? date('Y-m-d', strtotime($data['date_of_birth_hijri'])) : null,
        ]);
    }

    public function rules()
    {
        return [
            'fullname' => 'required|string|max:225|min:2',
            'email' => 'required|email|max:225|unique:users,email,' . $this->employee,
            'phone' => 'required|numeric|digits_between:10,20|unique:users,phone,' . $this->employee,
            'identity_number' => 'required|numeric|digits_between:10,20|unique:users,identity_number,' . $this->employee,
            'whatsapp' => 'required|numeric|digits_between:10,20|unique:users,whatsapp,' . $this->employee,
            'gender' => 'required|in:male,female',
            'is_ban' => 'in:1,0',
            "ban_reason" => 'required_if:is_ban,true|string|max:225|min:2',
            "is_ban_always" => 'required_if:is_ban,1|in:1,0',
            "ban_from" => 'required_if:is_ban_always,0|date',
            "ban_to" => 'required_if:is_ban_always,0|date',
            'date_of_birth' => 'required|date',
            'date_of_birth_hijri' => 'required|date',
            'image' => 'mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
