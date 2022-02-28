<?php

namespace App\Http\Requests\V1\Dashboard\Settings;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Setting;

class CreateSetting extends ApiMasterRequest
{
    public function authorize()
    {
        return true;
    }

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
