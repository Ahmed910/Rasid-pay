<?php

namespace App\Http\Resources\Dashboard\Regions;
use App\Http\Resources\Dashboard\ActivityLogResource;


use Illuminate\Http\Resources\Json\ResourceCollection;

class RegionCollection extends ResourceCollection
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
            'region' => RegionResource::make($this->collection['region']),
            'activity' => ActivityLogResource::collection($this->collection->except('region'))
        ];
    }
}
