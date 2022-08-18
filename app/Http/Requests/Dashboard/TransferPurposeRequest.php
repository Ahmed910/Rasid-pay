<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class TransferPurposeRequest extends ApiMasterRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"]   = "required|string|between:2,200|unique:transfer_purpose_translations,name,".$this->transfer_purpose?->id.',transfer_purpose_id';
        }
        $rules['is_default_value'] = 'nullable|in:0,1';
        $rules['is_active'] = 'nullable|in:0,1';

        return $rules;
    }

    public function messages()
    {
        $validation_messages = [];
        $validation = 'dashboard.transfer_purposes.validation';
        foreach (config('translatable.locales') as $locale) {
            $validation_messages["$locale.name.unique"]  = trans("$validation.$locale.name.unique");

        }
        return $validation_messages;
    }
}
