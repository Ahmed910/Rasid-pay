<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class BankRequest extends ApiMasterRequest
{
    public function rules()
    {
        $rules = [
            "image"         => "nullable|max:5120|mimes:jpg,png,jpeg",
            "is_active"     => "in:0,1",
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]  = "array";
            $rules["$locale.name"] = "required|between:2,100|regex:/^[\pL\pN\s\-\_]+$/u|unique:bank_translations,name," . @$this->bank->id  . ',bank_id';
        }
        return $rules;
    }

}
