<?php

namespace App\Http\Requests\V1\Dashboad;

use App\Http\Requests\ApiMasterRequest;
use function config;

class CityRequest extends ApiMasterRequest
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
            "country_id" => "nullable|exists:countries,id",
            "region_id" => "nullable|exists:regions,id",
            "postal_code" => "required|string|min:2|max:8",

        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = "required|max:255|string|unique:city_translations,name," . @$this->city->id. ",city_id";
        }

        return $rules;
    }
}

