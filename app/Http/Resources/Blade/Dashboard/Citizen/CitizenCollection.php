<?php

namespace App\Http\Resources\Blade\Dashboard\Citizen;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CitizenCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => CitizenResource::collection($this->collection),
            'draw' => (int) $request->draw,
            'recordsTotal' => (int) $this->additional['total_count'],
            'recordsFiltered' => (int) $this->additional['total_count']
        ];
    }
}
