<?php

namespace App\Http\Requests\V1\Dashboad;

use App\Http\Requests\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

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
            "name" => ["required"],
            "country_id" => ["required", "exist:countries"]
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"] = "array";
            $rules["$locale.name"] = "required|max:255|string|unique:department_translations,name," . ($this->id ?? 0);
            $rules["$locale.description"] = "required|string";
        }
        return $rules;
    }

//    public function messages()
//    {
//        return [
//            "name" => _(),
//            "country_id" => _(),
//        ];
//    }
}
