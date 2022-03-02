<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\ActivityLogResource;

class CountryResource extends JsonResource
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
            'phone_code' => $this->phone_code,
            'nationality' => $this->nationality,
            'currency' => CurrencyResource::make($this->whenLoaded('currency')),
            'activity' => ActivityLogResource::collection($this->whenLoaded('activity')),
            'created_at' => $this->created_at,
            'added_by ' => SimpleUserResource::make($this->whenLoaded('addedBy')),
            'activity'  => ActivityLogResource::collection($this->whenLoaded('activity')),
            'actions' => [
                'show' => auth()->user()->hasPermissions('countries.show'),
                'create' => auth()->user()->hasPermissions('countries.store'),
                'update' => auth()->user()->hasPermissions('countries.update'),
                'archive' => auth()->user()->hasPermissions('countries.archive'),
                'destroy' => auth()->user()->hasPermissions('countries.destroy'),
                'restore' => auth()->user()->hasPermissions('countries.restore'),
                'forceDelete' => auth()->user()->hasPermissions('countries.force_delete'),
            ]
        ] + $locales;
    }
}
