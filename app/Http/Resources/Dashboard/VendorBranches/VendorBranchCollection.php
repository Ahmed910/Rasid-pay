<?php

namespace App\Http\Resources\Dashboard\VendorBranches;

use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Http\Resources\Dashboard\VendorBranches\VendorBranchResource;
use App\Models\VendorBranches\VendorBranch;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VendorBranchCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $vendor_branch = VendorBranch::with('translations')
        ->findOrFail(@$request->route()->parameters['vendor_branch']);

        return [
            'client_branch' => VendorBranchResource::make($vendor_branch),
            'activity'    => ActivityLogResource::collection($this->collection)
        ];
    }
}
