<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use Illuminate\Support\Arr;

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
            "settings.*.en" => 'required'
        ];

        foreach (array_filter(config('translatable.locales'),fn ($locale) => $locale == "en" ? null : $locale) as $locale) {
            $rules["settings.*.$locale"] = "nullable";
        }

        return $rules;
    }
}
