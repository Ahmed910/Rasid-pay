<?php

namespace App\Http\Resources\Dashboard\Transaction;

use App\Http\Resources\Api\V1\Mobile\Transactions\TransactionResource;
use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Models\Transaction;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $transaction = Transaction::findOrFail(@$request->route()->parameters['transaction']);

        return [
            'transaction' => TransactionResource::make($transaction),
            'activity'    => ActivityLogResource::collection($this->collection)
        ];
    }
}
