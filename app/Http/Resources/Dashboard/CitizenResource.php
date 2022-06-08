<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\CitizenPackageResource;

class CitizenResource extends JsonResource
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

            'user' => SimpleCitizenResource::make($this->whenLoaded('user')),
            "lat" => $this->lat,
            "lng" => $this->lng,
            "location" => $this->location,
            'enabled_package' => CitizenPackageResource::make($this->whenLoaded('enabledPackage')),
            'card_end_at' => $this->enabledPackage?->end_at,
            'bank_name' => $this->bankAccount?->bank?->name,
            'created_at' => $this->created_at,
            'start_from' => $request->start,
            'token' => $this->when($this->token, $this->token),
            'actions' => $this->when($request->routeIs('citizens.index') || $request->routeIs('citizens.archive'), [
                'show' => auth()->user()->hasPermissions('citizens.show'),
                $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                    'create' => auth()->user()->hasPermissions('citizens.store'),
                    'update' => auth()->user()->hasPermissions('citizens.update')
                ])
            ])
        ];
    }
}
