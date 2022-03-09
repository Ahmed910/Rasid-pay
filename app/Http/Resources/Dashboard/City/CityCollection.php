<?php

namespace App\Http\Resources\Dashboard\City;

use App\Http\Resources\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CityCollection extends ResourceCollection
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
            'city' => CityResource::make($this->collection['city']),
            'activity' => ActivityLogResource::collection($this->collection->except('city'))
        ];
    }
}
