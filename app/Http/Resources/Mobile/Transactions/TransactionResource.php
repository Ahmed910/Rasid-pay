<?php

namespace App\Http\Resources\Mobile\Transactions;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Mobile\{UserResource, BeneficiaryResource};

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number' => $this->trans_number,
            'invoice_number' => $this->transactionable?->invoice_number,
            'amount' => $this->amount,
            'trans_type' => $this->trans_type,
            'trans_type_translate' => trans("mobile.transaction.transaction_types.{$this->trans_type}"),
            'trans_status' => $this->trans_status,
            'trans_status_translate' => trans("mobile.transaction.status_cases.{$this->trans_status}"),
            'transaction_id' => $this->transaction_id,
            'transaction_data' => $this->transaction_data,
            'qr_code' => $this->qr_path,
            'date' => $this->created_at,
            'from_user' => UserResource::make($this->fromUser),
            'to_user' => UserResource::make($this->toUser),
            'beneficiary' => BeneficiaryResource::make($this->transactionable?->beneficiary),
        ];
    }
}
