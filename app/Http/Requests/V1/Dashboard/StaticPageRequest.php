<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class StaticPageRequest extends ApiMasterRequest
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
            "image"         => "nullable|max:5120|mimes:jpg,png,jpeg",
            "is_active"     => "in:0,1",
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]               = "array";
            $rules["$locale.name"]          = "required|max:100|regex:/^[\pL\pN\s\-\_]+$/u|unique:static_page_translations,name," . @$this->static_page . ',static_page_id';
            $rules["$locale.description"]   = "required|string|max:5000";
        }

        return $rules;
    }

}
