<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class RegionRequest extends ApiMasterRequest
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
            "country_id" => ["required", "exists:countries,id"]
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = "required|max:255|string|unique:region_translations,name," . @$this->region->id . ',region_id';
        }
        return $rules;
    }

}
