<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class SlideRequest extends ApiMasterRequest
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
            "ordering"     => "required|numeric"
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]               = "array";
            $rules["$locale.name"]          = "required|between:2,100|regex:/^[\pL\pN\s\-\_]+$/u|unique:slide_translations,name," . $this->slide?->id  . ",slide_id";
            $rules["$locale.description"]   = "nullable|string|max:300";
        }

        return $rules;
    }
}
