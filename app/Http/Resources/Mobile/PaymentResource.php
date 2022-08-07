<?php

namespace App\Http\Resources\Mobile;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'invoice_number' => $this->invoice_number,
            'amount' => $this->amount,
            "description" => $this->description,
            "payment_type" => $this->payment_type,
            "payment_data" => $this->payment_data,
            'trans_number' => $this->transaction?->trans_number,
            'qr_code' => $this->transaction?->qr_path,
            'created_at' => $this->created_at,
            'total_amount' => $this->amount + $this->transaction?->fee_amount
        ];
    }
}
