<?php

namespace App\Http\Resources\Blade\Dashboard\RasidJob;

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
            'name' => $this->name,
            'department_name' => optional($this->department)->name,
            'department_image' => optional($this->department)->image,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
            'is_active' => $this->is_active,
            'is_vacant' => $this->is_vacant,
            'show_route' => route('dashboard.rasid_job.show', $this->id),
            'edit_route' => route('dashboard.rasid_job.edit', $this->id),
            'delete_route' => route('dashboard.rasid_job.destroy', $this->id),
            'forceDelete_route' =>route('dashboard.rasid_job.forceDelete', $this->id),
            'restore_route' =>route('dashboard.rasid_job.restore', $this->id),
            'start_from' => $request->start
        ];
    }
}
