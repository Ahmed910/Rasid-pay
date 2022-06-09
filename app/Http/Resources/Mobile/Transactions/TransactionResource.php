<?php

namespace App\Http\Resources\Mobile\Transactions;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'number'           => $this->trans_number,
            'amount'           => (float) $this->amount,
            'type'             => trans("dashboard.transaction.type_cases.{$this->trans_type}") ,
            'status'           => trans("dashboard.transaction.status_cases.{$this->trans_status}") ,
            'transaction_id'   => $this->transaction_id,
            'transaction_data' => $this->transaction_data,
            'qr_code'          => $this->qr_code,
            'date'             => $this->created_at
        ];
    }
}
