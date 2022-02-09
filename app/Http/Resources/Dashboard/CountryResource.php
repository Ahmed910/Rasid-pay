<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'created_at' => $this->created_at,
            'country' => CountryResource::make($this->whenLoaded('country')),
        ];
    }
}
