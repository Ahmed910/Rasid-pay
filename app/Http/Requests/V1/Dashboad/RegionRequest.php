<?php

namespace App\Http\Requests\V1\Dashboad;

use Illuminate\Foundation\Http\FormRequest;

class RegionRequest extends FormRequest
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
        return [
            "name" => ["required"],
            "country_id" => ["required", "exist:countries"]
        ];
    }

//    public function messages()
//    {
//        return [
//            "name" => _(),
//            "country_id" => _(),
//        ];
//    }
}
