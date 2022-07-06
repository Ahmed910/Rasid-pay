<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class LinkRequest extends ApiMasterRequest
{
   
    public function rules()
    {
        return [
            'key' => 'nullable|string|unique:links,key',
            'static_page_id' => 'nullable|exists:static_pages,id',
        ];
    }
}
