<?php

namespace App\Http\Resources\Dashboard\Banks;

use App\Models\Bank\Bank;
use App\Http\Resources\Dashboard\Banks\BankResource;
use App\Http\Resources\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BankCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $bank = Bank::withTrashed()->with('translations')->findOrFail(@$request->route()->parameters['bank']);
        return [
            'bank' => BankResource::make($bank),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
