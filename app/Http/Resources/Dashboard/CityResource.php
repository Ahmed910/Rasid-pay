<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
        if ($this->relationLoaded('translations') && !in_array($request->route()->getActionMethod(),['index','archive'])) {
            foreach (config('translatable.locales') as $locale) {
                $locales['translations'][$locale] = GlobalTransResource::make($this->translations->firstWhere('locale',$locale));
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'postal_code' => $this->postal_code,
            'created_at' => $this->created_at,
            'added_by ' => SimpleUserResource::make($this->whenLoaded('addedBy')),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'actions' => [
                'show' => auth()->user()->hasPermissions('cities.show'),
                'create' => auth()->user()->hasPermissions('cities.store'),
                'update' => auth()->user()->hasPermissions('cities.update'),
                'archive' => auth()->user()->hasPermissions('cities.archive'),
                'destroy' => auth()->user()->hasPermissions('cities.destroy'),
                'restore' => auth()->user()->hasPermissions('cities.restore'),
                'forceDelete' => auth()->user()->hasPermissions('cities.force_delete'),
            ]

        ] + $locales;
    }
}
