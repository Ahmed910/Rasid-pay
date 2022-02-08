<?php

namespace App\Http\Requests\Dashboad\V1;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
        $rules =
         [
          'value'=> 'required|numeric',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale]               = "array";
            $rules["$locale.name"]        = "required|max:255|string|unique:currency_translations,name," . $this->id;

        }

        return $rules;


    }
}
