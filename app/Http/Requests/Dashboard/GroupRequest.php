<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
     
        $rules =  [
            'permission_list' => 'required_without:group_list|array|min:1',
            'permission_list.*' => 'required_without:group_list|exists:permissions,id',
            'group_list' => 'required_without:permission_list|array|min:1',
            'group_list.*' => 'required_without:permission_list|exists:groups,id',
        ];
        if ($this->routeIs('dashboard.group.update')) {
            $rules['is_active'] = 'required|in:1,0';
        }
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.".name"] = 'required|string|between:2,100|regex:/^[\pL\pN\s\-\_]+$/u|unique:group_translations,name,' . @$this->group . ',group_id';
            $rules[$locale.'.desc'] = 'nullable|string|between:3,100000';
        }
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'permission_list.required_without' => trans('dashboard.general.Permission_field_required'),
            'group_list.required_without' => '',
        ];
        foreach (config('translatable.locales') as $locale) {
            $messages["{$locale}.name.unique"] = trans('dashboard.group.sorry_group_name_is_repeated');
            $messages["{$locale}.name.required"] =  trans('dashboard.group.group_name_required');
        }
        return $messages;

    }
}
