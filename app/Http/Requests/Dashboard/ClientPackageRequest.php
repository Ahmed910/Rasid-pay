<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Foundation\Http\FormRequest;

class ClientPackageRequest extends FormRequest
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
<<<<<<< HEAD:app/Http/Requests/Dashboard/ClientPackageRequest.php
            // "basic_discount" => "required|numeric|min:0|max:100|digits_between:1,5",
            // "golden_discount" => "required|numeric|min:0|max:100|digits_between:1,5",
            // "platinum_discount" => "required|numeric|min:0|max:100|digits_between:1,5",
            "image" => "nullable|max:5120|mimes:jpg,png,jpeg",
            'discounts' => 'required|array',
            'discounts.*' => 'required|array',
            'discounts.*.package_id' => 'required|exists:packages,id',
            'discounts.*.package_discount' => 'required|integer|gt:0|lte:100',
=======
            "basic_discount" => "required|numeric|min:0|max:100|digits_between:1,5",
            "golden_discount" => "required|numeric|min:0|max:100|digits_between:1,5",
            "platinum_discount" => "required|numeric|min:0|max:100|digits_between:1,5",
>>>>>>> 8314ae722768886102d264fa2aaf282f711eb59c:app/Http/Requests/Dashboard/PackageRequest.php
        ];
    }
}
