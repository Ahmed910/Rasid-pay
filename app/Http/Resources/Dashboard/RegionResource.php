<?php

namespace App\Http\Resources\Dashboard;

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
        return [
            'id' => $this->id,
            'translations' => GlobalTransResource::collection($this->whenLoaded('translations')),
            'name' => $this->name,
            'country' => CountryResource::make($this->whenLoaded('country')),
            'cities' => CityResource::collection($this->whenLoaded('cities')),
            'created_at' => $this->created_at,
            'actions' => [
                'show' => auth()->user()->hasPermissions('regions.show'),
                'create' => auth()->user()->hasPermissions('regions.store'),
                'update' => auth()->user()->hasPermissions('regions.update'),
                'archive' => auth()->user()->hasPermissions('regions.archive'),
                'destroy' => auth()->user()->hasPermissions('regions.destroy'),
                'restore' => auth()->user()->hasPermissions('regions.restore'),
                'forceDelete' => auth()->user()->hasPermissions('regions.force_delete'),
            ]
        ];
    }
}
