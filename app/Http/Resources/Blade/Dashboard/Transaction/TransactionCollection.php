<?php

namespace App\Http\Resources\Blade\Dashboard\Transaction;

use App\Http\Resources\Blade\Dashboard\transaction\TransactionResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => TransactionResource::collection($this->collection),
            'draw' => (int) $request->draw,
            'recordsTotal' => (int) $this->additional['total_count'],
            'recordsFiltered' => (int) $this->additional['total_count']
        ];
    }
}
