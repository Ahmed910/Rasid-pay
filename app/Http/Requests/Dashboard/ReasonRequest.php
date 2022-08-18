<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class ReasonRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "reasonAction" => ["required", "string", "max:300", "min:10"]
        ];
    }

    public function messages()
    {
        return [
            'reasonAction.max' => __('dashboard.general.validation.reason.max'),
            'reasonAction.min' => __('dashboard.general.validation.reason.min')
        ];
    }

}
