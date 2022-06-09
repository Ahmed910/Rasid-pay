<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
            "client_id" => "required|exists:users,id,user_type,client",
            "is_active" => "nullable|boolean",
            "basic_discount" => "required|numeric|min:0|max:100|digits_between:1,5",
            "golden_discount" => "required|numeric|min:0|max:100|digits_between:1,5",
            "platinum_discount" => "required|numeric|min:0|max:100|digits_between:1,5",
            "image" => "nullable|max:5120|mimes:jpg,png,jpeg",
        ];
    }
}
