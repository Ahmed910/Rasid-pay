<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class CardPackageUpdateRequest extends ApiMasterRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'discounts' => 'required|array',
            'discounts.*' => 'required|array',
            'discounts.*.package_id' => 'required|exists:packages,id',
            'discounts.*.package_discount' => 'required|integer|gt:0|lte:100',
        ];
    }
}
