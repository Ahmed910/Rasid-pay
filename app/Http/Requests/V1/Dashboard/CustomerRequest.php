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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "fullname" => ["required", "max:255", "string"],
            "email" => ["required", "max:255", "email", "unique:users,email"],
            "phone" => ["required", "unique:users,phone", "regex:/^([0-9\s\-\+\(\)]*)$/", "min:12", "max:12"],
            "whatsapp" => ["unique:users,whatsapp", "regex:/^([0-9\s\-\+\(\)]*)$/", "min:12", "max:12"],
            "password" => ["required", "min:8"],
            "identity_number" => ["required", "max:10", "unique:users,identity_number", "regex:/^([0-9\s\-\+\(\)]*)$/", "min:10", "max:10"],
            "client_type" => ["required", "in:company,Institution ,member,freelance_doc,famous,other"],
            "date_of_birth" => ["required", "date_format:Y-m-d"],
            "date_of_birth_hijri" => ["required", "date_format:Y-m-d"],
//            "image" => ["required"]
        ];
    }
}
