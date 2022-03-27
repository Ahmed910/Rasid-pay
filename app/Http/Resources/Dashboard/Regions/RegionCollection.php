<?php

namespace App\Http\Resources\Dashboard\Regions;
use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Models\Region\Region;
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
        $region = Region::withTrashed()->with('translations')->findOrFail(@$request->route()->parameters['region']);
        return [
            'region' => RegionResource::make($region),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
