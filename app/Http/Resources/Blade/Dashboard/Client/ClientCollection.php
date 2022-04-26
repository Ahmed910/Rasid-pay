<?php

namespace App\Http\Resources\Blade\Dashboard\Client;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => ClientResource::collection($this->collection),
            'draw' => (int) $request->draw,
            'recordsTotal' => (int) $this->additional['total_count'],
            'recordsFiltered' => (int) $this->additional['total_count']
        ];
    }
}
