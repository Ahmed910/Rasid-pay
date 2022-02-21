<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class RasidJobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
        [
        'id' => $this->id,
        'translations' => GlobalTransResource::collection($this->whenLoaded('translations')),
        'name' => $this->name,
        'is_active' => $this->is_active,
        'is_vacant' => $this->is_vacant,
        'created_at' => $this->created_at,
        'department' => DepartmentResource::make($this->whenLoaded('department')),
        ];
    }
}
