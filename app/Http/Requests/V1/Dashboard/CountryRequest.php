<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class CountryRequest extends ApiMasterRequest
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
//            'currency_id' => 'required|exists:currencies,id',
            'phone_code' => 'required|string|min:2|max:8|unique:countries,phone_code,' . @$this->country->phone_code . ',phone_code',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.name'] = 'required|max:255|unique:country_translations,name,' . @$this->country->id . ',country_id';
            $rules[$locale . '.nationality'] = 'required|max:255|unique:country_translations,nationality,' . @$this->country->id . ',country_id';
        }

        return $rules;
    }
}
