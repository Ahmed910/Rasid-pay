<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            "id" => $this->package?->id,
            "client" => SimpleUserResource::make($this),
            "basic_discount" => $this->package?->basic_discount,
            "golden_discount" => $this->package?->golden_discount,
            "platinum_discount" => $this->package?->platinum_discount,
            "is_active" => $this->is_active,
            "images" => ImagesResource::collection($this->whenLoaded("images")),
            'added_by' => SimpleUserResource::make($this->whenLoaded('addedBy')),
        ];
    }
}
