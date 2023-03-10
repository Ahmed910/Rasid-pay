<?php

namespace App\Http\Resources\Api\Dashboard\Regions;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Dashboard\City\CityResource;
use App\Http\Resources\Api\Dashboard\SimpleUserResource;
use App\Http\Resources\Api\Dashboard\ActivityLogResource;
use App\Http\Resources\Api\Dashboard\GlobalTransResource;
use App\Http\Resources\Api\Dashboard\Country\CountryResource;

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
            'created_at' => $this->created_at_date,
            'added_by ' => SimpleUserResource::make($this->whenLoaded('addedBy')),
            'activity'  => ActivityLogResource::collection($this->whenLoaded('activity')),
            'actions' => $this->when(in_array($request->route()->getActionMethod(),['index','archive']), [
                'show' => auth()->user()->hasPermissions('regions.show'),
                $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                    'create' => auth()->user()->hasPermissions('regions.store'),
                    'update' => auth()->user()->hasPermissions('regions.update'),
                    'destroy' => auth()->user()->hasPermissions('regions.destroy'),
                ]),
                $this->mergeWhen($request->route()->getActionMethod() == 'archive', [
                    'restore' => auth()->user()->hasPermissions('regions.restore'),
                    'forceDelete' => auth()->user()->hasPermissions('regions.force_delete')
                ]),
            ])
        ] + $locales;
    }
}
