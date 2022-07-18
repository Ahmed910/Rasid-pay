<?php

namespace App\Http\Resources\Api\V1\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $currentPackageDiscount = auth()->user()->citizen?->enabledPackage?->package_discount;
        return [
            'vendor' => VendorResource::make($this),
            'current_package_discount' => $currentPackageDiscount,
            'branches' => VendorBranchResource::collection($this->branches),
            'package' => VendorPackageResource::make($this->package)
        ];
    }
}
