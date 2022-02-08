<?php

namespace App\Http\Requests\V1\Dashboad;

use App\Http\Requests\ApiMasterRequest;

<<<<<<< HEAD
class CountryRequest extends ApiMasterRequest
=======
class CurrencyRequest extends FormRequest
>>>>>>> ad0e0016097d5390d00dff4864ea3da2edad354a
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
