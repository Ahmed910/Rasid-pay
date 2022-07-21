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
            "image"           => "nullable|max:5120|mimes:jpg,png,jpeg",
            "is_active"       => "in:0,1",
            "show_in_website" => "nullable|in:0,1",
            "show_in_app"     => "nullable|in:0,1",
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]               = "array";
            $rules["$locale.name"]          = "required|max:100|regex:/^[\pL\pN\s\-\_]+$/u|unique:static_page_translations,name," . @$this->static_page . ',static_page_id';
            $rules["$locale.description"]   = "required|string|max:50000";
        }

        return $rules;
    }
    public function messages()
    {
        $validation = 'dashboard.static_page.validation';

        $validation_messages = [

           'image.mimes' => trans($validation.'.image.mimes'),
           'image.max' => trans($validation.'.image.max'),
           'show_in_website.in' => trans($validation.'.show_in_website.in'),
           'show_in_app.in' => trans($validation.'.show_in_app.in'),
           'is_active.in' => trans($validation.'.is_active.in'),
        ];
        foreach (config('translatable.locales') as $locale) {
            $validation_messages["$locale.name.required"]  = trans("$validation.$locale.name.required");
            $validation_messages["$locale.name.max"]  = trans("$validation.$locale.name.max");
            $validation_messages["$locale.description.required"]  = trans("$validation.$locale.description.required");
            $validation_messages["$locale.description.max"]  = trans("$validation.$locale.description.max");
            $validation_messages["$locale.description.string"]  = trans("$validation.$locale.description.string");
        }


        return $validation_messages;
    }

}
