<?php

namespace App\Http\Resources\Blade\Dashboard\RasidJob;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RasidJobCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => RasidJobResource::collection($this->collection),
            'draw' => (int) $request->draw,
            'recordsTotal' => (int) $this->additional['total_count'],
            'recordsFiltered' => (int) $this->additional['total_count']
        ];
    }
}
