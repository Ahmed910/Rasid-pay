<?php

namespace App\Http\Requests\V1\Dashboard\Settings;

use App\Http\Requests\ApiMasterRequest;

class SettingRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $defaultLocale = config('app.locale', 'ar');
        $rules =  [
            "settings"      => 'required|array',
            "settings.*"    => 'required|array',
            "settings.*.$defaultLocale" => 'required'
        ];

        foreach (array_filter(config('translatable.locales'), fn ($locale) => $locale == $defaultLocale ? null : $locale) as $locale) {
            $rules["settings.*.$locale"] = "nullable";
        }

        return $rules;
    }
}
