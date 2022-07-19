<?php

namespace App\Http\Resources\Api\V1\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorPackageResource extends JsonResource
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
            'basic_discount' => $this->basic_discount,
            'golden_discount' => $this->golden_discount,
            'platinum_discount' => $this->platinum_discount,
        ];
    }
}
