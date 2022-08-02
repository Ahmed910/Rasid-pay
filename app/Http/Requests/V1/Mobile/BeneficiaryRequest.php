<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Beneficiary;

class BeneficiaryRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z_أ-ي ]+$/u',
            'benficiar_type' => 'required|in:' . implode(',', Beneficiary::TYPES),
            'transfer_relation_id' => 'nullable|required_if:benficiar_type,' . Beneficiary::GLOBAL_TYPE . '|exists:transfer_relations,id',
            'country_id' => 'nullable|required_if:benficiar_type,' . Beneficiary::GLOBAL_TYPE . '|exists:countries,id',
            'recieve_option_id' => 'nullable|required_if:benficiar_type,' . Beneficiary::GLOBAL_TYPE . '|exists:recieve_options,id',
            'nationality_id' => 'nullable|exists:countries,id',
            'date_of_birth' => 'nullable|date_format:Y-m-d|after_or_equal:1920-01-01|before:' . date("Y-m-d"),
            "iban_number" => ['required', 'starts_with:SA', "size:24", 'alpha_num', "unique:beneficiaries,iban_number," . @$this->beneficiary. ',id,user_id,'.auth()->id()],
            'is_saved' => 'required|in:1,0'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.beneficiaries.name.required'),
            'transfer_relation_id.required_if' => __('validation.beneficiaries.transfer_relation.required_if'),
            'country_id.required_if' => __('validation.beneficiaries.country.required_if'),
            'iban_number.required' => __('mobile.beneficiaries.iban_number.required'),
            'iban_number.starts_with' => __('mobile.beneficiaries.iban_number.starts_with', ['starts_with' => 'SA']),
            'iban_number.size' => __('mobile.beneficiaries.iban_number.size', ['size' => '24']),
            'iban_number.unique' => __('mobile.beneficiaries.iban_number.unique'),
        ];
    }
}
