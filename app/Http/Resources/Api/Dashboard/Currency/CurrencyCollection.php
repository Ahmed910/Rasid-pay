<?php

namespace App\Http\Resources\Api\Dashboard\Currency;

use App\Http\Resources\Api\Dashboard\ActivityLogResource;
use App\Models\Currency\Currency;
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
        $currency = Currency::withTrashed()->with('translations')->findOrFail(@$request->route()->parameters['currency']);

        return [
            'currency' => CurrencyResource::make($currency),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
