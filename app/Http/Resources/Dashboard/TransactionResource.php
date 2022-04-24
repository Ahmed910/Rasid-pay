<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'number' => $this->number,
            'amount' => $this->amount,
            'status' => $this->status,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'transaction_id' => $this->transaction_id,
            'transaction_data' => $this->transaction_data,
            'citizen' => CitizenResource::make($this->whenLoaded('citizen')),
            'client' => ClientResource::make($this->whenLoaded('client')),
            'card' => CardPackageResource::make($this->whenLoaded('card')),
        ];
    }
}
