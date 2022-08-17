<?php

namespace App\Http\Resources\Api\V1\Dashboard\Vendors;

use App\Http\Resources\Api\V1\Dashboard\ActivityLogResource;
use App\Models\Vendor\Vendor;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VendorCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $vendor = Vendor::with('translations','images','branches')->findOrFail(@$request->route()->parameters['vendor']);
        return [
            'vendor'   => VendorResource::make($vendor),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
