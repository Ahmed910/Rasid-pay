<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use function config;

class GroupRequest extends ApiMasterRequest
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
            'is_active'=>'required|in:1,0',
            'permission_list'=>'required|array',
            'permission_list.*'=>'required|string|exists:permissions,id'
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.".name"] = 'required|string|between:2,100|unique:group_translations,name,' . @$this->group->id . ',group_id';
            $rules[$locale.'.desc'] = 'nullable|string|between:3,100000';
        }
        return $rules;
    }
}
