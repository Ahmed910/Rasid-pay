<?php

namespace App\Http\Resources\Api\V1\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray($request)
    {
       
        return [
            'key'   => $this->key,
            'value' => $this->name,
        ];
    }
}
