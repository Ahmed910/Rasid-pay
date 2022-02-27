<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\Departments\DepartmentResource;
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
        return [
            'id' => $this->id,
            'translations' => GlobalTransResource::collection($this->whenLoaded('translations')),
            'name' => $this->name,
            'is_active' => $this->is_active,
            'is_vacant' => $this->is_vacant,
            'created_at' => $this->created_at,
            'department' => DepartmentResource::make($this->whenLoaded('department')),
            'actions' => [
                'show' => auth()->user()->hasPermissions('rasid_jobs.show'),
                'create' => auth()->user()->hasPermissions('rasid_jobs.store'),
                'update' => auth()->user()->hasPermissions('rasid_jobs.update'),
                'archive' => auth()->user()->hasPermissions('rasid_jobs.archive'),
                'destroy' => auth()->user()->hasPermissions('rasid_jobs.destroy'),
                'restore' => auth()->user()->hasPermissions('rasid_jobs.restore'),
                'forceDelete' => auth()->user()->hasPermissions('rasid_jobs.force_delete'),
            ]
        ];
    }
}
