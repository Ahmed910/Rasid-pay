<?php

namespace App\Http\Resources\Api\V1\Dashboard\VendorBranches;

use App\Http\Resources\Api\V1\Dashboard\ImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorBranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            "logo" => ImagesResource::collection($this->images),
            'vendor_id' => $this->vendor_id,
            'vendor_name' => $this->vendor?->name,
            'vendor_logo' => ImagesResource::collection($this->vendor?->images),
            'type' => $this->vendor?->type,
            'address_details' => $this->address_details,
            'location' => $this->location,
            'lat' => (string)$this->lat,
            'lng' => (string)$this->lng,
            'country_code' => substr($this->phone, 0, 3),
            'phone' => substr($this->phone, 3),
            'branch_coordinates' => branchCooridnatesResource::make($this),
            'email' => $this->email,
            'is_active' => (boolean)$this->is_active,
            'actions' => $this->when($request->routeIs('vendor_branches.index'), [
                'show' => auth()->user()->hasPermissions('vendor_branches.show'),
                'force_delete' => auth()->user()->hasPermissions('vendor_branches.destroy'),
                'update' => auth()->user()->hasPermissions('vendor_branches.update'),
            ])
        ];
    }
}
