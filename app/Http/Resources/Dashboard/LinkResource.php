<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'key'   => $this->key,
            'static_page_id' => $this->static_page_id
        ];
    }
}
