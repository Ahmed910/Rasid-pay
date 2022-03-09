<?php

namespace App\Http\Resources\Dashboard\Country;

use App\Http\Resources\Dashboard\Country\CountryResource;
use App\Http\Resources\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CountryCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'country' => CountryResource::make($this->collection['country']),
            'activity' => ActivityLogResource::collection($this->collection->except('country'))
        ];
    }
}
