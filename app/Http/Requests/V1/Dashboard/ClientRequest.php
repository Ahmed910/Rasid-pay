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
        return [
            "fullname" => ["required", "max:255", "string"],
            "email" => ["required", "max:255", "email", "unique:users,email," . @$this->client->id],
            "phone" => ["required", "unique:users,phone," . @$this->client->id, "regex:/^([0-9)]*)$/", "max:20"],
            "whatsapp" => ["unique:users,whatsapp," . @$this->client->id, "regex:/^([0-9]*)$/", "max:20"],
            "password" => ["required", "min:8"],
            "identity_number" => ["required", "unique:users,identity_number,". @$this->client->id, "regex:/^([0-9)]*)$/", "max:20"],
            "client_type" => ["required", "in:company,Institution ,member,freelance_doc,famous,other"],
            "user_type" => ["required", "in:admin,client"],
            "gender" => ["required", "in:male,female"],
            "date_of_birth" => ["required", "date"],
            "date_of_birth_hijri" => ["required", "date"],
            'is_ban' => 'required|boolean',
            'ban_reason' => 'nullable|required_if:is_ban,true|string|max:225',
            'is_ban_always' => 'nullable|required_if:is_ban,true|boolean',
            'ban_from' => 'nullable|required_if:is_ban_always,false|date',
            'ban_to' => 'nullable|required_if:is_ban_always,false|date',
            "is_admin_active_user"=>'required|boolean',
        ];
    }
}
