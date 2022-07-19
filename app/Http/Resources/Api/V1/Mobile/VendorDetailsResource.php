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
        $currentPackageDiscount = auth()->user()->citizen?->enabledPackage?->package_type;
        return [
            'vendor' => VendorResource::make($this),
            'branches' => VendorBranchResource::collection($this->branches),
            'current_package_type' => $currentPackageDiscount,
            'current_package_discount' => $this->package->{$currentPackageDiscount . '_discount'},
            'packages' => VendorPackageResource::make($this->package)
        ];
    }
}
