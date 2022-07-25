<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;

class CurrencyRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'base' => 'required|string|max:3',
            'to' => 'required|string|max:3',
            "amount" => ['required', 'numeric', 'gt:0'],
        ];
    }


    protected function prepareForValidation()
    {
        $data = $this->all();
        $this->merge([
            'amount' => @$data['amount'] ? convert_arabic_number($data['amount']) : @$data['amount'],
        ]);

    }

    public function messages()
    {
        return [
            'base.required' => trans('mobile.currencies.validation.base_required'),
            'to.required' => trans('mobile.currencies.validation.to_required'),
            'amount.gt' => trans('mobile.currencies.validation.gt'),
        ];
    }
}
