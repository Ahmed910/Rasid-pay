<?php

namespace App\Http\Resources\Dashboard\City;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\GlobalTransResource;
use App\Http\Resources\Dashboard\SimpleUserResource;
use App\Http\Resources\Dashboard\CountryResource;
use App\Http\Resources\Dashboard\ActivityLogResource;

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
        if ($this->relationLoaded('translations')) {
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
            'activity'  => ActivityLogResource::collection($this->whenLoaded('activity')),
            'actions' => $this->when(in_array($request->route()->getActionMethod(),['index','archive']), [
                'show' => auth()->user()->hasPermissions('cities.show'),
                $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                    'create' => auth()->user()->hasPermissions('cities.store'),
                    'update' => auth()->user()->hasPermissions('cities.update'),
                    'destroy' => auth()->user()->hasPermissions('cities.destroy'),
                ]),
                $this->mergeWhen($request->route()->getActionMethod() == 'archive', [
                    'restore' => auth()->user()->hasPermissions('cities.restore'),
                    'forceDelete' => auth()->user()->hasPermissions('cities.force_delete')
                ]),
            ])

        ] + $locales;
    }
}
