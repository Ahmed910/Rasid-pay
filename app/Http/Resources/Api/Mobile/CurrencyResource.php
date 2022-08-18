<?php

namespace App\Http\Resources\Api\Mobile;

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
            'id' => $this->country?->id,
            'currency_name' => $this->country?->currency,
            'currency_code' => $this->currency_code,
            'currency_value' => number_format($this->currency_value, 2),
        ] ;
    }
}
