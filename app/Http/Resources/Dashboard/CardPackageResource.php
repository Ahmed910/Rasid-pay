<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CardPackageResource extends JsonResource
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
            "id" => $this->cardPackage?->id,
            "client" => SimpleUserResource::make($this),
            "basic_discount" => $this->cardPackage?->basic_discount,
            "golden_discount" => $this->cardPackage?->golden_discount,
            "platinum_discount" => $this->cardPackage?->platinum_discount,
            "is_active" => $this->is_active,
            "images" => ImagesResource::collection($this->whenLoaded("images")),
            'added_by' => SimpleUserResource::make($this->whenLoaded('addedBy')),
        ];
    }
}
