<?php

namespace App\Http\Resources\Api\V1\Dashboard\Department;

use Illuminate\Http\Resources\Json\JsonResource;

class ParentResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
