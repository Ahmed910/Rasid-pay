<?php

namespace App\Http\Requests\Dashboard\Settings;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Setting;

class CreateSetting extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'settings'              => 'array|required',
            'settings.*.key'        => 'required',
            'settings.*.input_type' => 'required|in:' . implode(',', Setting::TYPES),
            'settings.*.value'      => 'required|array',
        ];
    }
}
