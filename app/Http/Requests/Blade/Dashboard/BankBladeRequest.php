<?php

namespace App\Http\Requests\Blade\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\BankBranch\BankBranch;

class BankBladeRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            "is_active"    => "nullable|in:0,1",
            'branches'        => 'required|array',
            'branches.*.id'   => '',
            'branches.*.type' => 'required|in:' . implode(',', BankBranch::TYPES),
            'branches.*.code' => 'required|string|min:2|max:20|regex:/^[\pL\pN\s\-\_\,]+$/u',
            'branches.*.site' => 'required|string|min:2|max:500|regex:/^[\pL\pN\s\-\_\,]+$/u',
            'branches.*.transfer_amount' => 'required|min:1|max:10|regex:/^[\pN\,\.]+$/u',
            'branches.*.commercial_record' => 'nullable|numeric|digits_between:10,20',
            'branches.*.tax_number' => 'nullable|numeric|digits_between:10,20',
            'branches.*.service_customer' => 'nullable|numeric|digits_between:10,20',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.name'] = 'required|max:100|regex:/^[\pL\pN\s\-\_\,]+$/u|unique:bank_translations,name,' . @$this->bank->id . ',bank_id';
            $rules['branches.*.' . $locale . '.name'] = 'required|string|min:2|max:100|regex:/^[\pL\pN\s\-\_\,]+$/u';
        }

        return $rules;
    }
}
