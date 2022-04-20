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
//        dd($this->all());
        $rules = [
            "is_active" => ["nullable", "boolean"],
            "ordering" => ["required", "numeric"],
            "price" => ["required", "max:255"],
            "offer" => ["nullable", "max:255"],
            "color" => ["nullable", "max:255"],
            "available_for_promo" => ["nullable", "boolean"],
            "cash_back" => ["required", "max:255"],
            "promo_cash_back" => ["required", "max:255"],
            "discount_promo_code" => ["required", "max:255"],
            "image"         => "nullable|max:5120|mimes:jpg,png,jpeg",

        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.name'] = 'required|max:255';
            $rules[$locale . '.description'] = 'nullable';

        };
        return $rules;
    }
}
