<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class UpdateCitizenStatusRequest extends ApiMasterRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "ban_status" => "required|in:active,temporary,permanent,exceeded_attempts",
            'ban_from' => 'nullable|required_if:ban_status,temporary|date|after:1900-01-01|before:ban_to',
            'ban_to' => 'nullable|required_if:ban_status,temporary|date|after_or_equal:ban_from|after:yesterday',
        ];
    }
}
