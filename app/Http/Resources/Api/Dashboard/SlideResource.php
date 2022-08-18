<?php

namespace App\Http\Resources\Api\Dashboard;

use App\Http\Resources\Api\Dashboard\GlobalTransResource;
use App\Http\Resources\Api\Dashboard\ImagesResource;
use App\Http\Resources\Api\Dashboard\SimpleUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource
{
    public function toArray($request)
    {
        $locales = [];
        if ($this->relationLoaded('translations')) {
            foreach (config('translatable.locales') as $locale) {
                $locales['translations'][$locale] = GlobalTransResource::make($this->translations->firstWhere('locale',$locale));
            }
        }
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_active'=>(bool) $this->is_active,
            'ordering'=>(int) $this->ordering,
            "images"    => ImagesResource::collection($this->whenLoaded("images")),
            'added_by'   => SimpleUserResource::make($this->whenLoaded('addedBy')),
        ] + $locales;
    }
}
