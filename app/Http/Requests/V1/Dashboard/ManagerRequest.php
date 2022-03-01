<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class ManagerRequest extends ApiMasterRequest
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
            "name" => ["required", "max:100", "string", "unique"],
            "email" => ["required", "max:100", "email", "unique:managers,email," . @$this->client->id],
            "phone" => ["required","starts_with:9665,05", "numeric", "digits_between:10,15", "unique:managers,phone," . @$this->client->id],
            "identity_number" => ["required", "numeric", "digits_between:5,10", "unique:managers,identity_number," . @$this->client->id],
            "gender" => ["nullable", "in:male,female"],
            "date_of_birth" => ["required", "date"],
            "address" => ["nullable","string" , "max:255"  ],
            "nationality" => ["nullable","string" , "max:255"  ],
            "marital_status" => ["nullable", "in:married,single"],


        ];
    }
}
