<?php

namespace App\Http\Resources\Api\Mobile;

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
            'amount' => number_format($this->amount, 2, '.', ''),
            "description" => $this->description,
            "payment_type" => $this->payment_type,
            "payment_data" => $this->payment_data,
            'trans_number' => $this->transaction?->trans_number,
            'qr_code' => asset($this->transaction?->qr_path),
            'created_at' => $this->created_at_date_time,
            'total_amount' => number_format(($this->amount + $this->transaction?->fee_amount), 2, '.', '')
        ];
    }
}
