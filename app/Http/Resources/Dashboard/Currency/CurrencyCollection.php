<?php

namespace App\Http\Resources\Dashboard\Currency;

use App\Http\Resources\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CurrencyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'currency' => CurrencyResource::make($this->collection['currency']),
            'activity' => ActivityLogResource::collection($this->collection->except('currency'))
        ];
    }
}
