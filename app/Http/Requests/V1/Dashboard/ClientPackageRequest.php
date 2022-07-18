<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class ClientPackageRequest extends ApiMasterRequest
{
    public function rules()
    {
        $rules =  [
            'basic_discount' => 'required|numeric|gte:0|lte:100|regex:/^\d{1,3}+(\.\d{0,2})?$/',
            'golden_discount' => 'required|gt:basic_discount|lte:100',
            'platinum_discount' => 'required|gt:golden_discount|lte:100',

        ];

        if (request()->isMethod('POST')) {
            $rules["vendor_id"] = "required|exists:vendors,id";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'golden_discount.gt' => __('validation.client_package.gold_gt_basic'),
            'platinum_discount.gt' => __('validation.client_package.platinum_gt_golden')
        ];
    }
}
