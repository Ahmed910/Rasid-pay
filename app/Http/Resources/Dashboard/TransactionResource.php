<?php

namespace App\Http\Resources\Dashboard;

use App\Models\Transaction;
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
        $status_codes = [
            'success' => 1,
            'fail' => 2,
            'pending' => 3,
            'received' => 4,
            'cancel' => 5,
        ];
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
            'status_code' => $status_codes[$this->status],
            'transaction_id' => $this->transaction_id,
            'transaction_data' => $this->transaction_data,
            'discount_percent' => $this->discount_percent,
            'card' => $this->card->name,
        ];
    }
}
