<?php

namespace App\Http\Resources\Api\V1\Dashboard;

use App\Http\Resources\Dashboard\GlobalTransResource;
use App\Http\Resources\Dashboard\ImagesResource;
use App\Http\Resources\Dashboard\SimpleUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
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
