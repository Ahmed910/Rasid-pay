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
            'is_vacant' => $this->is_vacant,
            'show_route' => route('dashboard.job.show', $this->id),
            'edit_route' => route('dashboard.job.edit', $this->id),
            'delete_route' => route('dashboard.job.destroy', $this->id)
        ];
    }
}
