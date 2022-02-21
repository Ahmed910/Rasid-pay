<?php

namespace App\Http\Resources\Dashboard\Role;

use App\Http\Resources\Dashboard\GlobalTransResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'is_active' => (bool)$this->is_active,
            'admins_count' => $this->admins->count(),
            'translations' => $this->when(!in_array($request->route()->getActionMethod(),['index','archive']),GlobalTransResource::collection($this->whenLoaded('translations'))),
            'created_at' => $this->created_at,
        ];
    }
}
