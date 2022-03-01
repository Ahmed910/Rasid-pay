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

    public function rules()
    {
        if ($this->admin) {
            $data = [
                'password_change' => 'required|in:1,0',
                'is_ban' => 'required|in:1,0',
                'password' => 'nullable|required_if:password_change,1|min:6|max:100|confirmed'
            ];
        } else {
            $data = [
                'employee_id' =>  'required|exists:users,id,user_type,employee',
                'password' => 'required|min:6|max:100'
            ];
        }
        return [
            'is_login_code' => 'required|in:1,0',
            'login_id' => 'required|digits:6|numeric|unique:users,login_id,' . @$this->admin . ',id,user_type,admin',
            // 'ban_reason' => 'nullable|required_if:is_ban,1|string|max:225',
            'is_ban_always' => 'nullable|required_if:is_ban,1|in:1,0',
            'ban_from' => 'nullable|required_if:iis_ban_always,0|date',
            'ban_to' => 'nullable|required_if:is_ban_always,0|date',
            'group_list' => 'required_without:permission_list|array|min:1',
            'group_list.*' => 'required_without:permission_list|exists:groups,id,is_active,1',
            'permission_list' => 'required_without:group_list|array|min:1',
            'permission_list.*' => 'required_without:group_list|exists:permissions,id',
        ] + $data;
    }
}
