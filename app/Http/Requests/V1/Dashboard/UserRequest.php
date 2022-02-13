<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use Illuminate\Validation\Rule;

class UserRequest extends ApiMasterRequest
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

        $rules =  [
            'fullname' => 'required|string|max:225',
            'email' => 'required|email|max:225|unique:users,email,' . @$this->user->id,
            'phone' => 'required|numeric|min:20|unique:users,phone,' . @$this->user->id,
            'identity_number' => 'required|numeric|min:20|unique:users,identity_number,' . @$this->user->id,
            'whatsapp' => 'required|max:225|max:20|unique:users,whatsapp,' . @$this->user->id,
            'user_type' => 'required|in:admin,client',
            "client_type" => 'required_if:user_type,client|in:admin,client',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'date_of_birth_hijri' => 'required|date',
        ];


        return $rules;
    }
}
