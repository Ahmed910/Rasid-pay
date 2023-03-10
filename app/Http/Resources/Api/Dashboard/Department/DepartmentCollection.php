<?php

namespace App\Http\Resources\Api\Dashboard\Department;

use App\Http\Resources\Api\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Department\Department;

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
        // dd(@$request->route()->parameters);
        $department = Department::withTrashed()->with('translations')->findOrFail(@$request->route()->parameters['department']);
        return [
            'department' => DepartmentResource::make($department),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
