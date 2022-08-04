<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
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
             'id'=> $this->id,
             'amount' => (double)$this->amount,
             'transfer_from_user'=>  UserResource::make($this->whenLoaded('from_user')),
             'transfer_to_user'=>  UserResource::make($this->whenLoaded('to_user')),
             'created_at' => $this->created_at,
             'transfer_status' => $this->transfer_status
        ];
    }
}
