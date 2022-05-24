<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use App\Models\BankBranch\BankBranch;

class BankRequest extends ApiMasterRequest
{
    public function rules()
    {
        $rules = [
            "is_active" => "nullable|in:0,1",
            'banks'     => 'required|array',
            'banks.*.name' => 'required|string|min:2|max:255',
            'banks.*.type' => 'required|in:' . implode(',', BankBranch::TYPES),
            'banks.*.code' => 'required|string|min:2|max:255',
            'banks.*.site' => 'required|string|min:2|max:255',
            'banks.*.transfer_amount' => 'required|numeric|min:0',
            'banks.*.commercial_record' => 'nullable|string|min:2|max:255',
            'banks.*.tax_number' => 'nullable|string|min:2|max:255',
            'banks.*.service_customer' => 'nullable|string|min:2|max:255',
            'banks.*.is_active' => 'nullable|in:0,1',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.name'] = 'required|max:255|unique:bank_translations,name,' . @$this->bank->id . ',bank_id';
        }

        return $rules;
    }
}
