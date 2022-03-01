<?php

namespace App\Http\Resources\Dashboard\Departments;

use App\Http\Resources\Dashboard\GlobalTransResource;
use App\Http\Resources\Dashboard\ImagesResource;
use App\Http\Resources\Dashboard\SimpleUserResource;
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
            'parent' => $this->parent?->translations()->where('locale', app()->getLocale())->value('name'),
            'parent_id' => $this->parent_id,
            'is_active' => (bool)$this->is_active,
            'created_at' => $this->created_at,
            'translations' => GlobalTransResource::collection($this->whenLoaded('translations')),
            "images"    => ImagesResource::collection($this->whenLoaded("images")),
            'added_by'   => SimpleUserResource::make($this->whenLoaded('addedBy')),
            'actions' => [
                'getParents'  => auth()->user()->hasPermissions('departments.get_parents'),
                'show' => auth()->user()->hasPermissions('departments.show'),
                'create' => auth()->user()->hasPermissions('departments.store'),
                'update' => auth()->user()->hasPermissions('departments.update'),
                'archive' => auth()->user()->hasPermissions('departments.archive'),
                'destroy' => auth()->user()->hasPermissions('departments.destroy'),
                'restore' => auth()->user()->hasPermissions('departments.restore'),
                'forceDelete' => auth()->user()->hasPermissions('departments.force_delete'),
            ]
        ];
    }
}
