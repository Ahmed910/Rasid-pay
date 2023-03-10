<?php

namespace App\Http\Resources\Api\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        switch ($this->wallet_transfer_method) {
        case "phone":
            $wallet_transfer_method = trans('mobile.transfers.by_phone').$this->phone;
            break;
        case "identity_number":
            $wallet_transfer_method = trans('mobile.transfers.by_identity_number').$this->toUser?->identity_number;
            break;
        case "wallet_number":
            $wallet_transfer_method = trans('mobile.transfers.by_wallet_number').$this->toUser?->citizenWallet?->wallet_number;
            break;
        default:
             $wallet_transfer_method = '';
        }
        return [
             'id'=> $this->id,
             'amount' => (string)$this->amount,
             'transfer_from_user'=>  UserResource::make($this->whenLoaded('fromUser')),
             'transfer_to_user'=>  UserResource::make($this->whenLoaded('toUser')),
             'created_at' => $this->created_at_date,
             'date' => $this->created_at_date_mobile,
             'time' => $this->created_at_time_mobile,
             'transfer_status' => $this->transfer_status,
             'transfer_details' => trans('mobile.transfers.transfer_details',  [ 'amount' => (string)$this->amount, 'wallet_transfer_method' => $wallet_transfer_method])
        ];
    }
}
