<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class ClientRequest extends ApiMasterRequest
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
        return [ //all unique tables checks needs to be handled
            "client_name" => ["required", "max:100", "string", "unique:users,fullname"],
//            "email" => ["required", "max:255", "email", "unique:users,email," . @$this->client->id],
            "phone" => ["nullable", "starts_with:9665,05", "numeric", "digits_between:10,20", "unique:users,phone," . @$this->client->id],
//            "whatsapp" => ["starts_with:9665","numeric", "digits_between:10,20", "unique:users,whatsapp," . @$this->client->id],
//            "identity_number" => ["required", "numeric", "digits_between:10,20", "unique:users,identity_number," . @$this->client->id],
            "client_type" => ["required", "in:company,Institution ,member,freelance_doc,famous,other"],
//            "user_type" => ["required", "in:admin,client"],
            "gender" => ["nullable", "in:male,female"],
//            "date_of_birth" => ["required", "date"],
//            "date_of_birth_hijri" => ["required", "date"],
//            'is_ban' => 'required|boolean',
//            'ban_reason' => 'nullable|required_if:is_ban,true|string|max:225',
//            'is_ban_always' => 'nullable|required_if:is_ban,true|boolean',
//            'ban_from' => 'nullable|required_if:is_ban_always,false|date',
//            'ban_to' => 'nullable|required_if:is_ban_always,false|date',
//            "is_admin_active_user" => 'required|boolean',
            "commercial_number" => "nullable|required_if:client_type,company,Institution,|string|max:10|unique",
            "tax_number" => ["required", "max:15", "string", "unique"],
            "register_type" => ["required", "in:delegate,direct"],
            "activity_type" => ["nullable", "string", "max:100"],
            "total_operations" => ["nullable", "numeric", "digits_between:1,15"],
            "bank_id" => ["required", "exists:banks,id"],
            "bank_account_number" => ["required", "string", "min:6", "max:24", "unique"],
            "address" => ["nullable", "string", "max:255"],
            "nationality" => ["nullable", "string", "max:255"],
            "married" => ["nullable", "bool"],
            "files.*" => ["file", "required_if:register_type,delegate"]


        ];
    }
}
