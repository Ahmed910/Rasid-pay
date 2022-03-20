<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Manager;
use App\Models\User;

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

    protected function prepareForValidation()
    {
        $data = $this->all();

        $this->merge([
            'manager_date_of_birth' => @$data['manager_date_of_birth'] ? date('Y-m-d', strtotime($data['date_of_birth'])) : null,
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
        $manager_id = !$this->client ?: User::find($this->client)->client()->pluck("manager_id")[0];
// TODO make unique checks with same [client , manager] [email ,phone  , identity ]
        return [
            "manager_name" => ["required", "max:100", "string"],
            "manager_email" => ["required", "max:100", "email", "unique:managers,manager_email," . @$manager_id . ",id", "unique:users,email," . @$this->client],
            "manager_phone" => ["required", "starts_with:9665,05", "numeric", "digits_between:10,15", "unique:managers,manager_phone," . @$manager_id, "unique:users,phone," . @$this->client],
            "manager_identity_number" => ["required", "numeric", "digits_between:5,10", "unique:managers,manager_identity_number," . @$manager_id, "unique:users,identity_number," . @$this->client],
            "manager_gender" => ["nullable", "in:male,female"],
            "manager_date_of_birth" => ["required", "date"],
            "manager_address" => ["nullable", "string", "max:255"],
            "manager_nationality" => ["nullable", "string", "max:255"],
            "manager_marital_status" => ["nullable", "in:married,single"],


        ];
    }
}
