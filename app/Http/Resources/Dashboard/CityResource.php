<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'translations' => GlobalTransResource::collection($this->whenLoaded('translations')),
            'name' => $this->name,
            'postal_code' => $this->postal_code,
            'created_at' => $this->created_at,
            'country' => CountryResource::make($this->whenLoaded('country')),
        ];
    }
}
