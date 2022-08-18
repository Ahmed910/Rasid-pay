<?php

namespace App\Http\Resources\Api\Mobile;

use App\Http\Resources\Api\Dashboard\ImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OurAppResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            "image" => $this->photo,
            'android_link' => $this->android_link,
            'ios_link' => $this->ios_link,
            'created_at' => $this->created_at_date,
            'order' => $this->order
        ];
    }
}
