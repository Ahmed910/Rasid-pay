<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class ClientPackageRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            "client_id" => "required|exists:users,id,user_type,client",
            "is_active" => "nullable|boolean",
            "image" => "nullable|max:5120|mimes:jpg,png,jpeg",
            'discounts' => 'required|array',
            'discounts.*' => 'required|array',
            'discounts.*.package_id' => 'required|exists:packages,id',
            'discounts.1.package_discount' => 'required|gt:discounts.0.package_discount',
            'discounts.2.package_discount' => 'required|gt:discounts.1.package_discount',
            'discounts.*.package_discount' => 'required|numeric|gte:0|lte:100|regex:/^\d{1,3}+(\.\d{0,2})?$/',

        ];
    }

    public function messages()
    {
        return [
            'discounts.1.package_discount.gt' => __('validation.client_package.gold_gt_basic'),
            'discounts.2.package_discount.gt' => __('validation.client_package.platinum_gt_golden')
        ];
    }
}
