<?php

namespace App\Http\Resources\Api\Dashboard\Department;

use App\Http\Resources\Api\Dashboard\ActivityLogResource;
use App\Http\Resources\Api\Dashboard\GlobalTransResource;
use App\Http\Resources\Api\Dashboard\ImagesResource;
use App\Http\Resources\Api\Dashboard\SimpleUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $locales = [];
        if ($this->relationLoaded('translations')) {
            foreach (config('translatable.locales') as $locale) {
                $locales['translations'][$locale] = GlobalTransResource::make($this->translations->firstWhere('locale', $locale));
            }
        }
        return [
                'id' => $this->id,
                'name' => $this->name,
                'parent' => $this->parent?->translations()->where('locale', app()->getLocale())->value('name'),
                'parent_id' => $this->parent_id,
                'is_active' => (bool)$this->is_active,
                'created_at' => $this->created_at_date,
                'deleted_at' => $this->deleted_at_date,
                'has_children' => $this->children()->exists(),
                'has_jobs' => $this->rasidJobs()->exists(),
                "images" => ImagesResource::collection($this->whenLoaded("images")),
                'added_by' => SimpleUserResource::make($this->whenLoaded('addedBy')),
                'activity' => ActivityLogResource::collection($this->whenLoaded('activity')),
                'actions' => $this->when($request->routeIs('departments.index') || $request->routeIs('departments.archive'), [
                    'show' => auth()->user()->hasPermissions('departments.show'),
                    $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                        'create' => auth()->user()->hasPermissions('departments.store'),
                        'update' => auth()->user()->hasPermissions('departments.update'),
                        'destroy' => auth()->user()->hasPermissions('departments.destroy'),
                    ]),
                    $this->mergeWhen($request->route()->getActionMethod() == 'archive', [
                        'restore' => auth()->user()->hasPermissions('departments.restore'),
                        'forceDelete' => auth()->user()->hasPermissions('departments.force_delete')
                    ]),
                ])
            ] + $locales;
    }
}
