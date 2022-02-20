<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class SettingRequest extends ApiMasterRequest
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
            "settings"      => 'required|array',
            "settings.*"    => 'required|array',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["settings.*.$locale"] = "required";
        }

        return $rules;
    }
}
