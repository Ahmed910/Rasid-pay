<?php

namespace App\Http\Requests\Mobile;

use App\Http\Requests\ApiMasterRequest;
use App\Models\CitizenPackage;
use Illuminate\Validation\Rule;

class PromotePackageRequest extends ApiMasterRequest
{
    public function rules()
    {

        return [
            'package_type' => 'required|in:' . implode(',', CitizenPackage::PACKAGE_TYPES),
            "promo_code" => ["nullable",
                Rule::exists('citizen_package_promo_codes', 'promo_code')
                    ->where('is_used', false)],
        ];
    }

    public function messages()
    {
        return [
            'package_type.required' => trans('mobile.promotion.package_is_required'),
            'package_type.in' => trans('mobile.promotion.package_is_not_found'),
            'promo_code.exists' => trans('mobile.promotion.promo_code_is_not_found'),
        ];
    }
}
