<?php

namespace App\Http\Resources\Dashboard\VendorBranches;

use Illuminate\Http\Resources\Json\JsonResource;

class branchCooridnatesResource extends JsonResource
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
            'lat' => (string)$this->lat,
            'lng' => (string)$this->lng,
        ];
    }
}
