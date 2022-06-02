<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use App\Models\BankBranch\BankBranch;

class BankRequest extends ApiMasterRequest
{
    public function rules()
    {
        $rules = [
            "is_active"    => "nullable|in:0,1",
            'banks'        => 'required|array',
            'banks.*.id'   => '',
            'banks.*.type' => 'required|in:' . implode(',', BankBranch::TYPES),
            'banks.*.code' => 'required|string|min:2|max:20|regex:/^[\pL\pN\s\-\_\,]+$/u',
            'banks.*.site' => 'required|string|min:2|max:500|regex:/^[\pL\pN\s\-\_\,]+$/u',
            'banks.*.transfer_amount' => 'required|numeric|digits_between:1,8|regex:/^[\pN\,\.]+$/u',
            'banks.*.commercial_record' => 'nullable|numeric|digits_between:10,20',
            'banks.*.tax_number' => 'nullable|numeric|digits_between:10,20',
            'banks.*.service_customer' => 'nullable|numeric|digits_between:10,20',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.name'] = 'required|max:100|regex:/^[\pL\pN\s\-\_\,]+$/u|unique:bank_translations,name,' . @$this->bank->id . ',bank_id';
            $rules['banks.*.' . $locale . '.name'] = 'required|string|min:2|max:100|regex:/^[\pL\pN\s\-\_\,]+$/u';
        }

        return $rules;
    }
}
