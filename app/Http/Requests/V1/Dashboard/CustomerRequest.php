<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class CustomerRequest extends ApiMasterRequest
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
            'date_of_birth_hijri' => @$data['date_of_birth_hijri'] ? date('Y-m-d', strtotime($data['date_of_birth_hijri'])) : null,
            'phone' => @$data['phone'] ? convert_arabic_number($data['phone']) : null

        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "fullname" => ["required", "max:255", "string"],
            "email" => ["required", "max:255", "email", "unique:users,email," . @$this->customer->id],
            "phone" => ["required", "unique:users,phone," . @$this->customer->id, "regex:/^([0-9)]*)$/", "max:20"],
            "whatsapp" => ["unique:users,whatsapp," . @$this->customer->id, "regex:/^([0-9]*)$/", "max:20"],
            "password" => ["required", "min:8"],
            "identity_number" => ["required", "unique:users,identity_number", "regex:/^([0-9\s\-\+\(\)]*)$/", "max:20," . @$this->customer->id],
            "client_type" => ["required", "in:company,Institution ,member,freelance_doc,famous,other"],
            "user_type" => ["required", "in:admin,client"],
            "gender" => ["required", "in:male,female"],
            "date_of_birth" => ["required", "date"],
            "date_of_birth_hijri" => ["required", "date"],
        ];
    }
}
