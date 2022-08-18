<?php

namespace App\Http\Requests\Mobile;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Beneficiary;

class CardRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'card_name' => 'required|string|max:255',
        ];
    }
}
