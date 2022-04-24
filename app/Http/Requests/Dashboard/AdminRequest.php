<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use GeniusTS\HijriDate\Hijri;

class AdminRequest extends FormRequest
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
    protected function prepareForValidation()
    {
        $data = $this->all();
        if (auth()->check() && auth()->user()->is_date_hijri) {
            if (@$data['ban_from']) {
                $ban_from = explode('-', $data['ban_from']);
                $data['ban_from'] = Hijri::convertToGregorian($ban_from[2], $ban_from[1], $ban_from[0])->format('Y-m-d');
            }
            if (@$data['ban_to']) {
                $ban_to = explode('-', $data['ban_to']);
                $data['ban_to'] = Hijri::convertToGregorian($ban_to[2], $ban_to[1], $ban_to[0])->format('Y-m-d');
            }
        }
        if ((!isset($data['change_password']) || $data['change_password'] == 0) && $this->admin) {
            $data['password'] = null;
        }

        $this->merge([
            'ban_from' =>  @$data['ban_from'] ?? null,
            'ban_to' =>  @$data['ban_to'] ?? null,
            'password' => $data['password'] ?? null
        ]);
    }

    public function rules()
    {
        if ($this->admin) {
            $data = [
                'change_password' => 'nullable|in:1,0',
                'ban_status' => 'required|in:active,permanent,temporary',
                'password' => 'nullable|required_if:change_password,1|regex:/^[A-Za-z0-9()\]\[#%&*_=~{}^:`.,$!@+\/-]+$/|min:6|max:100'
            ];
        } else {
            $data = [
                'department_id' => 'required|exists:departments,id',
                'employee_id' =>  'required|exists:users,id,user_type,employee',
                'password' => 'required|regex:/^[A-Za-z0-9()\]\[#%&*_=~{}^:`.,$!@+\/-]+$/|min:6|max:100',
                'login_id' => 'required|digits:6|numeric|unique:users,login_id,' . @$this->admin->id . ',id,user_type,admin',
            ];
        }
        return [
            'is_login_code' => 'in:1,0',
            'ban_from' => 'nullable|required_if:ban_status,temporary|date|after:1900-01-01',
            'ban_to' => 'nullable|required_if:ban_status,temporary|date|after_or_equal:ban_from',
            'group_list' => 'required_without:permission_list|array',
            'group_list.*' => 'required_without:permission_list|exists:groups,id',
            'permission_list' => 'required_without:group_list|array',
            'permission_list.*' => 'required_without:group_list|exists:permissions,id',
            'delete_image'  => "in:0,1"
        ] + $data;
    }

    public function messages()
    {
        return [
            'permission_list.required_without' => trans('dashboard.general.Permission_field_required'),
            'group_list.required_without' => '',
        ];
    }
}
