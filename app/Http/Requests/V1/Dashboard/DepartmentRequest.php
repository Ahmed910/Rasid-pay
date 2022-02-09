<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class DepartmentRequest extends ApiMasterRequest
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
            "image"     => "required|image|max:2048",
            "parent_id" => "nullable|exists:departments,id",

        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]               = "array";
            $rules["$locale.name"]          = "required|max:255|string|unique:department_translations,name," . $this->department?->id  . ",department_id";
            $rules["$locale.description"]   = "required|string";
        }

        return $rules;
    }
}
