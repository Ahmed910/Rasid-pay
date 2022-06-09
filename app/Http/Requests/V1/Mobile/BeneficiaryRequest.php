<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Beneficiary;

class BeneficiaryRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'name'              => 'required|string|max:255',
            'benficiar_type'    => 'required|in:' . implode(',', Beneficiary::TYPES),
            'iban_number'       => 'required_if:benficiar_type,' . Beneficiary::LOCAL_TYPE,
            'relation'          => 'nullable|required_if:benficiar_type,' . Beneficiary::GLOBAL_TYPE . 'string|',
            'country_id'        => 'nullable|required_if:benficiar_type,' . Beneficiary::GLOBAL_TYPE . '|exists:countries,id',
            'recieve_option_id' => 'nullable|required_if:benficiar_type,' . Beneficiary::GLOBAL_TYPE . '|exists:recieve_options,id',
            'nationality'       => 'nullable|string',
            'date_of_birth'     => 'nullable|date|after_or_equal:1920-01-01',
        ];
    }
}
