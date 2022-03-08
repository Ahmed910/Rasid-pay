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
                'ban_status' => 'required|in:active,permanent,temporary',
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
            'ban_from' => 'nullable|required_if:ban_status,temporary|date',
            'ban_to' => 'nullable|required_if:ban_status,temporary|date|after_or_equal:ban_from',
            'group_list' => 'required_without:permission_list|array|min:1',
            'group_list.*' => 'required_without:permission_list|exists:groups,id',
            'permission_list' => 'required_without:group_list|array|min:1',
            'permission_list.*' => 'required_without:group_list|exists:permissions,id',
        ] + $data;
    }
}
