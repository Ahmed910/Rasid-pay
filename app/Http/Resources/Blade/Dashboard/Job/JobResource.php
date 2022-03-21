<?php

namespace App\Http\Resources\Blade\Dashboard\Job;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            'department_name' => optional($this->department)->name,
            'created_at' => $this->created_at,
            'is_active' => $this->is_active,
            'show_route' => route('dashboard.jobs.show', $this->id),
            'edit_route' => route('dashboard.jobs.edit', $this->id),
            'delete_route' => route('dashboard.jobs.destroy', $this->id)
        ];
    }
}
