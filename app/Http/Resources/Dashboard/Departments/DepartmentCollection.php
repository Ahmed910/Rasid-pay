<?php

namespace App\Http\Resources\Dashboard\Departments;

use App\Http\Resources\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DepartmentCollection extends ResourceCollection
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
            'department' => DepartmentResource::make($this->collection['department']),
            'activity' => ActivityLogResource::collection($this->collection->except('department'))
        ];
    }
}
