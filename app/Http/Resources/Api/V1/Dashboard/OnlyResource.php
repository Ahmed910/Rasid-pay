<?php

namespace App\Http\Resources\Api\V1\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class OnlyResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
