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
        $this->manager_phone = convert_arabic_number($this->manager_phone);
        if (isset( $this->manager_phone))
            $forvalidation = $this->manager_phone[0]=="0" ?substr($this->manager_phone , 1) : $this->manager_phone ;
        $this->merge([
            'manager_date_of_birth' => @$data['manager_date_of_birth'] ? date('Y-m-d', strtotime($data['manager_date_of_birth'])) : null,
            'manager_phone' => @$data['manager_phone'] ? convert_arabic_number($data['manager_phone']) : null,
            'manager_country_code' => @$data['manager_country_code'] ? convert_arabic_number($data['manager_country_code']) : null,
            'manager_full_phone' => $this->manager_country_code . $forvalidation

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
            "manager_country_code" => "required|in:" . countries_list(),
            "manager_email" => ["required", "max:100", "email", "unique:managers,manager_email," . @$manager_id . ",id"],
            "manager_phone" => ["required", "not_regex:/^{$this->manager_country_code}/", "numeric", "digits_between:7,15",],
            "manager_full_phone" => ["unique:managers,manager_phone," . @$manager_id],
            "manager_identity_number" => ["required", "numeric", "digits_between:5,10", "unique:managers,manager_identity_number," . @$manager_id],
            "manager_gender" => ["nullable", "in:male,female"],
            "manager_date_of_birth" => ["required", "date"],
            "manager_address" => ["nullable", "string", "max:255"],
            "manager_nationality" => ["nullable", "string", "max:255"],
            "manager_marital_status" => ["nullable", "in:married,single"],


        ];
    }
}
