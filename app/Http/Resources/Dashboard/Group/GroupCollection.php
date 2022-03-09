<?php

namespace App\Http\Resources\Dashboard\Group;

use App\Http\Resources\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GroupCollection extends ResourceCollection
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
            'group' => GroupResource::make($this->collection['group']),
            'activity' => ActivityLogResource::collection($this->collection->except(['group','permissions'])),
            'permissions' => PermissionResource::collection($this->collection['permissions'])
        ];
    }
}
