<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;

class TestRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'image' => 'nullable|max:1024|mimes:jpg,png,jpeg',
        ];
    }
}
