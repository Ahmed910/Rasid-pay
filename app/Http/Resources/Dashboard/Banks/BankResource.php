<?php

namespace App\Http\Resources\Dashboard\Banks;

use App\Http\Resources\Dashboard\ImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\ActivityLogResource;

class BankResource extends JsonResource
{
    public function toArray($request)
    {


        return [
            'id'   => $this->id,
            'name' => $this->name,
            'is_active' => (bool) $this->is_active,
            'created_at' => $this->created_at,
            "images" => ImagesResource::collection($this->whenLoaded("images")),
            'activity' => ActivityLogResource::collection($this->whenLoaded('activity')),
            'actions' => $this->when($request->routeIs('banks.index') || $request->routeIs('banks.archive'), [
                'show' => auth()->user()->hasPermissions('banks.show'),
                $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                    'create' => auth()->user()->hasPermissions('banks.store'),
                    'update' => auth()->user()->hasPermissions('banks.update'),
                    'destroy' => auth()->user()->hasPermissions('banks.destroy'),
                ])
            ])
        ];
    }
}
