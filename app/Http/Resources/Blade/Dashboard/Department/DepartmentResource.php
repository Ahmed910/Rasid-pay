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
            'active_case' => trans('dashboard.general.active_cases.'.$this->is_active),
            'has_jobs'  => $this->rasidJobs()->exists(),
            'show_route' => route('dashboard.department.show', $this->id),
            'edit_route' => route('dashboard.department.edit', $this->id),
            'delete_route' => route('dashboard.department.destroy', $this->id),
            'restore_route' => route('dashboard.department.restore', $this->id),
            'forceDelete_route' => route('dashboard.department.forceDelete', $this->id)

        ];
    }
}
