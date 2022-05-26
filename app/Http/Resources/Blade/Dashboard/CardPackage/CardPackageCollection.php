<?php

namespace App\Http\Resources\Blade\Dashboard\CardPackage;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CardPackageCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => CardPackageResource::collection($this->collection),
            'draw' => (int) $request->draw,
            'recordsTotal' => (int) $this->additional['total_count'],
            'recordsFiltered' => (int) $this->additional['total_count']
        ];
    }
}
