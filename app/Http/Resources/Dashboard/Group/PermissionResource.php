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
        $uri = str_before($this->name,'.');
        $single_uri = str_singular($uri);
        return [
            'id' => $this->id,
            'uri' => $this->name,
            'name' => trans('dashboard.' . $single_uri . '.' . $uri) . ' (' . trans('dashboard.' . $single_uri . '.permissions.' . str_after($this->name,'.')) . ')',
            'created_at' => $this->created_at
        ];
    }
}
