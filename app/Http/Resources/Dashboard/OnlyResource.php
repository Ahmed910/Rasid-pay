<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class OnlyResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
