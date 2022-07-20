<?php

namespace App\Http\Resources\Dashboard\VendorBranches;

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
            'logo' => $this->logo,
            'vendor_name' => $this->vendor?->name,
            'vendor_logo' => $this->vendor?->logo,
            'is_support_maak' => (boolean)$this->vendor?->is_support_maak,
            'type' => $this->vendor?->type,
            'address_details' => $this->address_details,
            'location' => $this->location,
            'lat' => (string)$this->lat,
            'lng' => (string)$this->lng,
            'country_code' => substr($this->phone, 0, 4),
            'phone' => substr($this->phone, 4),
            'email' => $this->email,
            'is_active' => (boolean)$this->is_active,
            'actions' => $this->when($request->routeIs('vendor_branches.index'), [
                'show' => auth()->user()->hasPermissions('vendor_branches.show'),
                'destroy' => auth()->user()->hasPermissions('vendor_branches.destroy'),
            ])
        ];
    }
}
