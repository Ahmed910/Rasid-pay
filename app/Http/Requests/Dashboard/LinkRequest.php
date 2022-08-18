<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class LinkRequest extends ApiMasterRequest
{

    public function rules()
    {
        return [
            'static_page_id' => 'nullable|exists:static_pages,id',
        ];
    }
}
