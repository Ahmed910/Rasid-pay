<?php

namespace App\Http\Resources\Api\V1\Mobile;

use App\Http\Resources\Dashboard\ImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OurAppResource extends JsonResource
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
                'description' => $this->description,
                "images" => ImagesResource::collection($this->whenLoaded("images")),
                'created_at' => $this->created_at,
            ];

    }
}
