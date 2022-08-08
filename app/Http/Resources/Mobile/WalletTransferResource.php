<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'transfer_type' => $this->transfer_type,
            'amount' => (string) $this->amount,
            'transfer_fees' => (string) $this->transfer_fees,
            'transfer_number' => $this->transaction?->trans_number,
            'wallet_transfer_method' => $this->wallet_transfer_method,
        ];
    }
}
