<?php

namespace App\Http\Resources\Api\Dashboard\TransferPurpose;

use Illuminate\Http\Resources\Json\JsonResource;

class TransferPurposeResource extends JsonResource
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
            'name' => $this->name,
            'is_active' => (bool)$this->is_active,
            'is_default_value' => (bool)$this->is_default_value,
            'actions' => $this->when($request->routeIs('transfer_purposes.index'), [
                'update' => !$this->is_another && auth()->user()->hasPermissions('transfer_purposes.update'),
                'destroy' => !$this->is_another && auth()->user()->hasPermissions('transfer_purposes.destroy'),
                'show' => auth()->user()->hasPermissions('transfer_purposes.show'),

            ])
        ] ;
    }
}
