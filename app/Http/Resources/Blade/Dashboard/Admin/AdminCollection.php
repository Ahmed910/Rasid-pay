<?php

namespace App\Http\Resources\Blade\Dashboard\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => AdminResource::collection($this->collection),
            'draw' => (int) $request->draw,
            'recordsTotal' => (int) $this->additional['total_count'],
            'recordsFiltered' => (int) $this->additional['total_count']
        ];
    }
}
