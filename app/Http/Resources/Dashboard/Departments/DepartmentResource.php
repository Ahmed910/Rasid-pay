<?php

namespace App\Http\Resources\Dashboard\Departments;

use App\Http\Resources\Dashboard\GlobalTransResource;
use App\Http\Resources\Dashboard\ImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'name' => $this->name,
            'parent' => $this->parent?->translations()->where('locale', app()->getLocale())->first()->name,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'translations' => GlobalTransResource::collection($this->whenLoaded('translations')),
            "images"    => ImagesResource::collection($this->whenLoaded("images"))
        ];
    }
}
