<?php

namespace App\Http\Resources\Dashboard\RasidJob;

use App\Http\Resources\Dashboard\{ActivityLogResource, GlobalTransResource, SimpleEmployeeResource, SimpleUserResource};
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
        $locales = [];
        if ($this->relationLoaded('translations')) {
            foreach (config('translatable.locales') as $locale) {
                $locales['translations'][$locale] = GlobalTransResource::make($this->translations->firstWhere('locale',$locale));
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'is_vacant' => $this->is_vacant,
            'created_at' => $this->created_at,
            'added_by ' => SimpleUserResource::make($this->whenLoaded('addedBy')),
            'employee ' => SimpleEmployeeResource::make($this->whenLoaded('employee')),
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
        ] + $locales;
    }
}
