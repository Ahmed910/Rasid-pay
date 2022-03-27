<?php

namespace App\Http\Resources\Dashboard\City;

use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Models\City\City;
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
        $city = City::withTrashed()->with('translations')->findOrFail(@$request->route()->parameters['city']);

        return [
            'city' => CityResource::make($city),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
