<?php

namespace App\Http\Requests\Mobile;

use App\Http\Requests\ApiMasterRequest;

class TestRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'name' => 'required|min:2',
            'image' => 'required|max:1024|mimes:jpg,png,jpeg',
        ];
    }
}
