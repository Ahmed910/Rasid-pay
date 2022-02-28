<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class CurrencyRequest extends ApiMasterRequest
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
            'value' => 'required|max:9|regex:/^\d*(\.\d{2})?$/',
            'added_by_id' =>'nullable|exists:users,id',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.name'] = 'required|max:255|unique:currency_translations,name,' . @$this->currency->id . ',currency_id';
        }
        return $rules;
    }
}
