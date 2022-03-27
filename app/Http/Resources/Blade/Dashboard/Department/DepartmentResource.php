<?php

namespace App\Http\Resources\Blade\Dashboard\Department;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Lang;

class DepartmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent' => $this->parent,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
            'is_active' => $this->is_active,
            'show_route' => route('dashboard.departments.show', $this->id),
            'edit_route' => route('dashboard.departments.edit', $this->id),
            'delete_route' => route('dashboard.departments.destroy', $this->id)
        ];
    }
}
