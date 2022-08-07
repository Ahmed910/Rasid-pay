<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'id'          => $this->id,
            'fullname'    => $this->fullname,
            'image'    => $this->image,
            'client_type' => $this->client ? trans('dashboard.client.client_type.'.$this->client->client_type) : null,
            'discounts'   => ClientDiscountResource::collection($this->whenLoaded('clientPackages')),
            //TODO::add provider branches after implementing it
        ] ;
    }
}
