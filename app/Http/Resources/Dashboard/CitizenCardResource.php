<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\CardPackageResource;

class CitizenCardResource extends JsonResource
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
            'card_package' => CardPackageResource::make($this->whenLoaded('cardPackage')),
            'card_price' => $this->card_price,
            'card_data' => $this->card_data,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
        ];
    }
}
