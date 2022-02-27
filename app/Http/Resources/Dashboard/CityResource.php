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
        return [
            'id' => $this->id,
            'translations' => GlobalTransResource::collection($this->whenLoaded('translations')),
            'name' => $this->name,
            'postal_code' => $this->postal_code,
            'created_at' => $this->created_at,
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

        ];
    }
}
