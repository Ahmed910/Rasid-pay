<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class LocalizationRequest extends ApiMasterRequest
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
        $rules = [
            "local" => "required|in:en,ar|exists:locale_translations,locale,locale_id," . @$this->localization,
        ];

        $locale = $this->local;
        $rules["$locale"] = "array";
        $rules["$locale.value"] = "required|between:1,255";
        $rules["$locale.desc"] = "nullable|string|max:300";

        return $rules;
    }
}
