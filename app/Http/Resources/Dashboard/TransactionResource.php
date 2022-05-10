<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'number' => $this->number,
            'created_at' => $this->created_at,
            'citizen' => $this->citizen?->fullname,
            'user_identity' => $this->user_identity,
            'client' => $this->client?->user?->fullname,
            'amount' => (string)$this->amount,
            'total_amount' => (string)$this->total_amount,
            'gift_balance' => (string)$this->gift_balance,
            'type' => $this->type ? trans("dashboard.transaction.type_cases.{$this->type}") : "",
            'status' => $this->status ? trans("dashboard.transaction.status_cases.{$this->status}") : "",
            'discount_percent' => $this->card->name.' / '.$this->discount_percent.'%',
        ];
    }
}
