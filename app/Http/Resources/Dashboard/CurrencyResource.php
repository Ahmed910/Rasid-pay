<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
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
            'translations' =>  GlobalTransResource::collection($this->whenLoaded('translations')),
            'name' => $this->name,
            'value' => $this->value,
            'created_at'=>$this->created_at,
            'actions' => [
                'index'  => auth()->user()->hasPermissions('currencies.index'),
                'show' => auth()->user()->hasPermissions('currencies.show'),
                'create' => auth()->user()->hasPermissions('currencies.store'),
                'update' => auth()->user()->hasPermissions('currencies.update'),
                'archive' => auth()->user()->hasPermissions('currencies.archive'),
                'destroy' => auth()->user()->hasPermissions('currencies.destroy'),
                'restore' => auth()->user()->hasPermissions('currencies.restore'),
                'forceDelete' => auth()->user()->hasPermissions('currencies.force_delete'),
            ]
        ];

    }
}
