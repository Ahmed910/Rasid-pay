<?php

namespace App\Http\Requests\V1\Dashboad;

use App\Http\Requests\ApiMasterRequest;
use function config;

class RoleRequest extends ApiMasterRequest
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
            'permissions'=>'required|array',
            'permissions.*'=>'required|array',
            'permissions.*.*'=>'required|array'
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.".name"] = 'required|string|between:2,250';
            $rules[$locale.'.desc'] = 'nullable|string|between:3,100000';
        }
        return $rules;
    }
}

