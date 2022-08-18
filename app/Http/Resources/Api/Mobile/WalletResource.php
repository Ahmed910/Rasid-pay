<?php

namespace App\Http\Resources\Api\Mobile;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            'trans_number' => $this->trans_number,
            'citizen_name'   => $this->citizen->fullname,
            'wallet_number'  => (string)$this->wallet_number,
            'main_balance'   => number_format($this->main_balance, 2,'.',''),
            'cash_back'      => number_format($this->cash_back, 2,'.',''),
            'total_balance'  => number_format(($this->main_balance + $this->cash_back), 2,'.',''),
            'wallet_qr'      => $this->qr_code,
            'last_updated'   => $this->last_updated_at?->format('g:i A'),
            'avatar'         => $this->citizen->image
        ];
    }
}
