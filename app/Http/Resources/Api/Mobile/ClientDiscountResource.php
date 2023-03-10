<?php

namespace App\Http\Resources\Api\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientDiscountResource extends JsonResource
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
            'description' => $this->description,
            'is_default' => (bool)$this->is_default,
            'discount' => $this->pivot?->package_discount,
        ] ;
    }
}
