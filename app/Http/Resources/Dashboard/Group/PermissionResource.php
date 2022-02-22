<?php

namespace App\Http\Resources\Dashboard\Group;

use App\Http\Resources\Dashboard\GlobalTransResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'name' => trans('dashboard.'.str_before($this->name,'.') . '.permissions.'.str_after($this->name,'.')),
            'uri' => $this->name,
            'created_at' => $this->created_at,
        ];
    }
}
