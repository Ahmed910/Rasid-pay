<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id' => $this->id,
            'translations' => GlobalTransResource::collection($this->whenLoaded('translations')),
            'name' => $this->name,
            'phone_code' => $this->phone_code,
            'nationality' => $this->nationality,
            'currency' => CurrencyResource::make($this->whenLoaded('currency')),
            'activity' => ActivityLogResource::collection($this->whenLoaded('activity')),
            'created_at' => $this->created_at,
            'added_by ' => SimpleUserResource::make($this->whenLoaded('addedBy')),
            'actions' => [
                'show' => auth()->user()->hasPermissions('countries.show'),
                'create' => auth()->user()->hasPermissions('countries.store'),
                'update' => auth()->user()->hasPermissions('countries.update'),
                'archive' => auth()->user()->hasPermissions('countries.archive'),
                'destroy' => auth()->user()->hasPermissions('countries.destroy'),
                'restore' => auth()->user()->hasPermissions('countries.restore'),
                'forceDelete' => auth()->user()->hasPermissions('countries.force_delete'),
            ]
        ];
    }
}
