<?php

namespace App\Http\Resources\Api\V1\Mobile;

use App\Http\Resources\Dashboard\ImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OurAppResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            "images" => ImagesResource::collection($this->whenLoaded("images")),
            'android_link' => $this->android_link,
            'ios_link' => $this->ios_link,
            'created_at' => $this->created_at,
            'order' => $this->order
        ];
    }
}
