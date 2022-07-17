<?php

namespace App\Http\Resources\Dashboard\Vendors;

use App\Http\Resources\Dashboard\ActivityLogResource;
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
        $vendor = Vendor::with('translations','images')->findOrFail(@$request->route()->parameters['vendor']);
        return [
            'vendor'   => VendorResource::make($vendor),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
