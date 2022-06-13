<?php

namespace App\Http\Resources\Mobile;

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
            'citizen_name'   => $this->citizen->fullname,
            'wallet_number'  => (string)$this->wallet_number,
            'main_balance'   => (string)$this->main_balance,
            'cash_back'      => (string)$this->cash_back,
            'total_balance'  => (string)$this->main_balance + $this->gift_balance,
            'wallet_qr'      => $this->wallet_qr	,
            'last_updated'   => Carbon::parse($this->last_updated_at)->diffForHumans(),
        ];
    }
}
