<?php

namespace App\Http\Requests\Mobile;

use App\Http\Requests\ApiMasterRequest;

class CurrencyRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'base' => 'required|string|max:3',
            'to' => 'required|string|max:3',
        ];
    }
    public function messages()
    {
        return [
            'base.required' => trans('mobile.currencies.validation.base_required'),
            'to.required' => trans('mobile.currencies.validation.to_required'),
        ];
    }
}
