<?php

namespace App\Http\Resources\Dashboard;
use Illuminate\Http\Resources\Json\JsonResource;

class CitizenPackageResource extends JsonResource
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
            'name' => $this->package?->name,
            'package_price' => $this->package_price,
            'package_discount' => $this->package_discount,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
        ];
    }
}
