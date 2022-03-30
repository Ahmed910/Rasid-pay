<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use GeniusTS\HijriDate\Hijri;

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
        $this->merge([
            'ban_from' =>  @$data['ban_from'] ?? null,
            'ban_to' =>  @$data['ban_to'] ?? null,
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
            'is_login_code' => 'in:1,0',
            'login_id' => 'required|digits:6|numeric|unique:users,login_id,' . @$this->admin . ',id,user_type,admin',
            'ban_from' => 'nullable|required_if:ban_status,temporary|date|after:1900-01-01',
            'ban_to' => 'nullable|required_if:ban_status,temporary|date|after_or_equal:ban_from',
            'group_list' => 'required_without:permission_list|array|min:1',
            'group_list.*' => 'required_without:permission_list|exists:groups,id',
            'permission_list' => 'required_without:group_list|array|min:1',
            'permission_list.*' => 'required_without:group_list|exists:permissions,id',
            'delete_image'  => "in:0,1"
        ] + $data;
    }
}
