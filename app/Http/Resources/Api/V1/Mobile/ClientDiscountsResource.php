<?php

namespace App\Http\Resources\Api\V1\Mobile;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientDiscountsResource extends JsonResource
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
            'user_id' => $this->id,
            'fullname' => $this->fullname,
            'avatar' => $this->image,
            'discount' => $this->pivot?->package_discount
        ];
    }
}
