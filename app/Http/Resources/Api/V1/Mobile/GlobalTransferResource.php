<?php

namespace App\Http\Resources\Api\V1\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class GlobalTransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'transfer_type' => $this->transaction?->trans_type,
            'date' => $this->transaction?->created_at,
            'qr_code' => asset($this->transaction?->qr_path) ?? "",
            'trans_number' => $this->transaction->trans_number,
            'mtcn_number' => $this->bankTransfer->mtcn_number,
            'balance_type' => $this->bankTransfer->balance_type,
            'amount' => $this->amount,
            'to_currency' => $this->bankTransfer->toCurrency->currency_code,
            'exchange_rate' => $this->bankTransfer->exchange_rate,
            'transfer_fees' => $this->transfer_fees ?? 0,
            'total_amount' => (string)($this->amount + $this->transfer_fees),
            'recieve_option' => $this->bankTransfer?->recieveOption?->name,
            'beneficiary' => BeneficiaryResource::make($this?->beneficiary),
            'transfer_purpose' => $this->transferPurpose?->name,
        ];
    }
}
