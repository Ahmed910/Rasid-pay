<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
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
                $locales['translations'][$locale] = GlobalTransResource::make($this->translations->firstWhere('locale',$locale));
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'country' => CountryResource::make($this->whenLoaded('country')),
            'cities' => CityResource::collection($this->whenLoaded('cities')),
            'created_at' => $this->created_at,
            'added_by ' => SimpleUserResource::make($this->whenLoaded('addedBy')),
            'activity'  => ActivityLogResource::collection($this->whenLoaded('activity')),
            'actions' => [
                'show' => auth()->user()->hasPermissions('regions.show'),
                'create' => auth()->user()->hasPermissions('regions.store'),
                'update' => auth()->user()->hasPermissions('regions.update'),
                'archive' => auth()->user()->hasPermissions('regions.archive'),
                'destroy' => auth()->user()->hasPermissions('regions.destroy'),
                'restore' => auth()->user()->hasPermissions('regions.restore'),
                'forceDelete' => auth()->user()->hasPermissions('regions.force_delete'),
            ]
        ] + $locales;
    }
}
