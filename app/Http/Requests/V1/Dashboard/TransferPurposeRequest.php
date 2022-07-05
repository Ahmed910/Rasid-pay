<?php

namespace App\Http\Requests\V1\Dashboard;

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
            $rules["$locale.name"]   = "required|string|between:2,200";
        }
        $rules['is_default_value'] = 'nullable|in:0,1';
        return $rules;
    }
}
