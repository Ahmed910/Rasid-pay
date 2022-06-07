<?php

namespace App\Http\Resources\Mobile\Transactions;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'number'           => $this->number,
            'amount'           => $this->amount,
            'type'             => $this->type,
            'status'           => $this->status,
            'transaction_id'   => $this->transaction_id,
            'transaction_data' => $this->transaction_data,
            'qr_code'          => $this->qr_code,
            'date'             => $this->created_at
        ];
    }
}
