<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ClientPackageRequest extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "client_id" => "required|exists:users,id,user_type,client",
            "is_active" => "nullable|boolean",
            "image" => "nullable|max:5120|mimes:jpg,png,jpeg",
            'discounts' => 'required|array',
            'discounts.*' => 'required|array',
            'discounts.*.package_id' => 'required|exists:packages,id',
            'discounts.*.package_discount' => 'required|integer|gte:0|lte:100',
            'discounts.1.package_discount' => 'gt:discounts.0.package_discount',
            'discounts.2.package_discount' => 'gt:discounts.1.package_discount',

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
