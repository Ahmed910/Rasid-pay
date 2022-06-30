<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class StaticPageRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "image"         => "nullable|max:5120|mimes:jpg,png,jpeg",
            "is_active"     => "in:0,1",
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]               = "array";
            $rules["$locale.name"]          = "required|max:100|regex:/^[\pL\pN\s\-\_]+$/u|unique:static_page_translations,name," . @$this->static_page?->id . ',static_page_id';
            $rules["$locale.description"]   = "required|string|max:300000";
        }

        return $rules;
    }

}
