<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class LocalizationRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'id'    => 'required|exists:locale_translations,id',
            'value' => 'required|string|max:255',
            'desc'  => 'nullbale|string|max:500'
        ];
    }
}
