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
            "fullname" => ["required", "max:100", "string" ],
            "email" => ["required", "max:255", "email", "unique:users,email," . @$this->client->id],
            "phone" => ["nullable", "starts_with:9665,05", "numeric", "digits_between:10,20", "unique:users,phone," . @$this->client->id],
            "identity_number" => ["required", "numeric", "digits_between:10,20", "unique:users,identity_number," . @$this->client->id],
            "client_type" => ["required", "in:company,Institution ,member,freelance_doc,famous,other"],
            "gender" => ["nullable", "in:male,female"],
            "date_of_birth" => ["required", "date"],
            "commercial_number" => "nullable|required_if:client_type,company,Institution|string|max:10|unique:clients,commercial_number,".@$this->client->commercial_number,
            "tax_number" => ["required", "max:15", "string", "unique:clients,tax_number"],
            "register_type" => ["required", "in:delegate,direct"],
            "activity_type" => ["nullable", "string", "max:100"],
            "daily_expect_trans" => ["required", "numeric", "digits_between:1,15"],
            "address" => ["nullable", "string", "max:255"],
            "nationality" => ["nullable", "string", "max:255" , "min:2"],
            "marital_status" => ["nullable", "in:married,single"],


        ];
    }
}
