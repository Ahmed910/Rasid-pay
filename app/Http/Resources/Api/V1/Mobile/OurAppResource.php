<?php

namespace App\Http\Resources\Api\V1\Mobile;

use App\Http\Resources\Dashboard\GlobalTransResource;
use App\Http\Resources\Dashboard\ImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OurAppResource extends JsonResource
{
    public function toArray($request)
    {
        $locales = [];
        if ($this->relationLoaded('translations')) {
            foreach (config('translatable.locales') as $locale) {
                $locales['translations'][$locale] = GlobalTransResource::make($this->translations->firstWhere('locale', $locale));
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => (bool) $this->is_active,
            'android_link' => $this->android_link,
            'ios_link' => $this->ios_link,
            "images" => ImagesResource::collection($this->whenLoaded("images")),
            'created_at' => $this->created_at,
        ] + $locales;
    }
}
