<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;
use App\Models\CitizenPackage;

class VendorDiscountRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "package_type" => "required|in:" . implode(",", CitizenPackage::PACKAGE_TYPES),
        ];
    }
}
