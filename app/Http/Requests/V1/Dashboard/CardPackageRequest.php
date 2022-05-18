<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class CardPackageRequest extends ApiMasterRequest
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
            "is_active" => ["nullable", "boolean"],
            "basic_discount" => ["required", "string", "min:1", "max:255", "digits_between:1,15"],
            "golden_discount" => ["required", "string", "min:1", "max:255", "digits_between:1,15"],
            "platinum_discount" =>["required", "string", "min:1", "max:255", "digits_between:1,15"],
            "client_id" => ["required", "exists:users,id,user_type,client"],
            "image" => "nullable|max:5120|mimes:jpg,png,jpeg",
        ];

        return $rules;
    }
}
