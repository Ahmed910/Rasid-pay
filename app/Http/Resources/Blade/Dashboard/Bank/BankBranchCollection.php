<?php

namespace App\Http\Resources\Blade\Dashboard\Bank;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BankBranchCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => BankBranchResource::collection($this->collection),
            'draw' => (int) $request->draw,
            'recordsTotal' => (int) $this->additional['total_count'],
            'recordsFiltered' => (int) $this->additional['total_count']
        ];
    }
}
