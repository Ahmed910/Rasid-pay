<?php

namespace App\Http\Resources\Blade\Dashboard\Activitylog;

use Illuminate\Http\Resources\Json\ResourceCollection;
use  App\Http\Resources\Dashboard\ActivityLogResource;

class ActivityLogCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => ActivityLogResource::collection($this->collection),
            'draw' => (int) $request->draw,
            'recordsTotal' => (int) $this->additional['total_count'],
            'recordsFiltered' => (int) $this->additional['total_count']
        ];
    }
}
