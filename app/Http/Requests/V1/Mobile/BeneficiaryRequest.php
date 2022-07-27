<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Beneficiary;

class BeneficiaryRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'name'                 => 'required|string|max:255',
            'benficiar_type'       => 'required|in:' . implode(',', Beneficiary::TYPES),
            'transfer_relation_id' => 'nullable|required_if:benficiar_type,' . Beneficiary::GLOBAL_TYPE,
            'country_id'           => 'nullable|required_if:benficiar_type,' . Beneficiary::GLOBAL_TYPE . '|exists:countries,id',
            'recieve_option_id'    => 'nullable|required_if:benficiar_type,' . Beneficiary::GLOBAL_TYPE . '|exists:recieve_options,id',
            'nationality_id'       => 'nullable|exists:countries,id',
            'date_of_birth'        => 'nullable|date|after_or_equal:1920-01-01',
            'iban_number'          => ['required_if:benficiar_type,' . Beneficiary::LOCAL_TYPE, 'alpha_num', "size:24"],
            'is_saved' => 'required|in:1,0'
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>  __('validation.beneficiaries.name.required'),
            'transfer_relation_id.required_if' =>  __('validation.beneficiaries.transfer_relation.required_if'),
            'country_id.required_if' =>  __('validation.beneficiaries.country.required_if'),
        ];
    }
}
