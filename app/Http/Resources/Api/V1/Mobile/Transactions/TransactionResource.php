<?php

namespace App\Http\Resources\Api\V1\Mobile\Transactions;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\Mobile\{UserResource, BeneficiaryResource};

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'trans_number' => $this->trans_number,
            'amount' => $this->amount,
            'trans_type' => $this->trans_type,
            'invoice_number' => $this->when($this->transactionable?->invoice_number, 'payment'),
            'transaction_id' => $this->when($this->transactionable?->bankTransfer?->mtcn_number, 'global_transfer'),
            'trans_type_translate' => trans("mobile.transaction.transaction_types.{$this->trans_type}"),
            'trans_status' => $this->trans_status,
            'trans_status_translate' => trans("mobile.transaction.status_cases.{$this->trans_status}"),
            'to_currency' => $this->transactionable?->bankTransfer?->toCurrency?->currency_code,
            'exchange_rate' => $this->transactionable?->bankTransfer?->exchange_rate,
            'to_amount' => $this->amount * $this->transactionable?->bankTransfer?->exchange_rate,
            'transfer_fees' => $this->transactionable?->transfer_fees ?? 0,
            'total_amount' => (string)($this->amount + $this->transfer_fees),
            'transfer_purpose' => $this->transactionable?->transferPurpose?->name,
            'recieve_option' => $this->transactionable?->bankTransfer?->recieveOption?->name,
            'qr_code' => asset($this->qr_path),
            'date' => $this->created_at,
            'from_user' => UserResource::make($this->fromUser),
            'to_user' => UserResource::make($this->toUser),
            'beneficiary' => BeneficiaryResource::make($this->transactionable?->beneficiary),
            'notes' => $this->transactionable?->notes
        ];
    }
}
