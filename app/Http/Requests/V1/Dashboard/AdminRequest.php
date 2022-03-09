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


    protected function prepareForValidation()
    {
        $data = $this->all();

        $this->merge([
            'ban_from' =>  @$data['ban_from'] ? date('Y-m-d', strtotime($data['ban_from'])) : null,
            'ban_to' =>  @$data['ban_to'] ? date('Y-m-d', strtotime($data['ban_to'])) : null,
        ]);
    }

    public function rules()
    {
        if ($this->admin) {
            $data = [
                'password_change' => 'required|in:1,0',
                'ban_status' => 'required|in:active,permanent,temporary',
                'password' => 'nullable|required_if:password_change,1|regex:/^[A-Za-z0-9()\]\[#%&*_=~{}^:`.,$!@+\/-]+$/|min:6|max:100|confirmed'
            ];
        } else {
            $data = [
                'employee_id' =>  'required|exists:users,id,user_type,employee',
                'password' => 'required|numeric|digits_between:6,10'
            ];
        }
        return [
            'is_login_code' => 'required|in:1,0',
            'login_id' => 'required|digits:6|numeric|unique:users,login_id,' . @$this->admin . ',id,user_type,admin',
            'ban_from' => 'nullable|required_if:ban_status,temporary|date|after:1900-01-01',
            'ban_to' => 'nullable|required_if:ban_status,temporary|date|after_or_equal:ban_from',
            'group_list' => 'required_without:permission_list|array|min:1',
            'group_list.*' => 'required_without:permission_list|exists:groups,id',
            'permission_list' => 'required_without:group_list|array|min:1',
            'permission_list.*' => 'required_without:group_list|exists:permissions,id',
        ] + $data;
    }
}
