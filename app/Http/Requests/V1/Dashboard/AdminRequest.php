<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class AdminRequest extends ApiMasterRequest
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


    // protected function prepareForValidation()
    // {
    //     $data = $this->all();

    //     $this->merge([
    //         'date_of_birth' =>  @$data['date_of_birth'] ? date('Y-m-d', strtotime($data['date_of_birth'])) : null,
    //         'date_of_birth_hijri' =>  @$data['date_of_birth_hijri'] ? date('Y-m-d', strtotime($data['date_of_birth_hijri'])) : null,
    //     ]);
    // }

    // public function rules()
    // {
    //     return [
    //         'fullname' => 'required|string|max:225',
    //         'email' => 'required|email|max:225|unique:users,email,' . @$this->admin->id,
    //         'phone' => 'required|numeric|min:20|unique:users,phone,' . @$this->admin->id,
    //         'identity_number' => 'required|numeric|min:20|unique:users,identity_number,' . @$this->admin->id,
    //         'whatsapp' => 'required|max:20|unique:users,whatsapp,' . @$this->admin->id,
    //         'user_type' => 'required|in:admin,client',
    //         'group_id' => 'required|exists:roles,id',
    //         "client_type" => 'required_if:user_type,client|in:admin,client',
    //         'gender' => 'required|in:male,female',
    //         'date_of_birth' => 'required|date',
    //         'date_of_birth_hijri' => 'required|date',
    //     ];
    // }

    public function rules()
    {
        if ($this->admin) {
            $ruleEmployee = 'nullable|exists:users,id';
            $rulePassChanged = 'required|boolean';
            $ruleBan = 'required|boolean';
        } else {
            $ruleEmployee = 'required|exists:users,id';
            $rulePassChanged = 'nullable';
            $ruleBan = 'nullable';
        }
        return [
            'employee_id' => $ruleEmployee,
            'password_change' => $rulePassChanged,
            'password' => 'nullable|required_if:password_change,true|confirmed|min:6|max:225',
            'is_login_code' => 'required|boolean',
            'login_id' => 'required|max:6|numeric|unique:users,login_id,'.@$this->admin->id.'id,user_type,admin',
            'is_ban' => $ruleBan,
            'ban_reason' => 'nullable|required_if:is_ban,true|string|max:225',
            'is_ban_always' => 'nullable|required_if:is_ban,true|boolean',
            'ban_from' => 'nullable|required_if:is_ban_always,false|date',
            'ban_to' => 'nullable|required_if:is_ban_always,false|date',
            'group_list' => 'required_without:permission_list|array|min:1',
            'group_list.*' => 'required_without:permission_list|exists:groups,id,is_active,1',
            'permission_list' => 'required_without:group_list|array|min:1',
            'permission_list.*' => 'required_without:group_list|exists:permissions,id',
        ];
    }
}
