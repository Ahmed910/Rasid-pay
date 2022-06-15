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
            'trans_type_translate'  => trans("dashboard.transaction.type_cases.{$this->trans_type}"),
            'trans_type'       => $this->trans_type,
            'trans_status_translate'=> $this->trans_status,
            'trans_status'     => trans("dashboard.transaction.status_cases.{$this->trans_status}"),
            'transaction_id'   => $this->transaction_id,
            'transaction_data' => $this->transaction_data,
            'qr_code'          => $this->qr_path,
            'date'             => $this->created_at
        ];
    }
}
