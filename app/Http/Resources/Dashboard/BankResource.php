<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
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
            'created_at' => $this->created_at,
            'actions' => [
                'show' => auth()->user()->hasPermissions('banks.show'),
                'create' => auth()->user()->hasPermissions('banks.store'),
                'update' => auth()->user()->hasPermissions('banks.update'),
                'archive' => auth()->user()->hasPermissions('banks.archive'),
                'destroy' => auth()->user()->hasPermissions('banks.destroy'),
                'restore' => auth()->user()->hasPermissions('banks.restore'),
                'forceDelete' => auth()->user()->hasPermissions('banks.force_delete'),
            ]

        ];
    }
}
