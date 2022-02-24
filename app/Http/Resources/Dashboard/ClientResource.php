<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'gender' => $this->gender,
            'is_active' => $this->is_active,
            'is_ban' => $this->is_ban,
            "Commercial_number"=>$this->Commercial_number,
            "tax_number"=>$this->tax_number,
            "bank_account_number"=>$this->bank_account_number,
            "bank_id"=>$this->bank_id,
            "activity_type"=>$this->activity_type,
            "operations_count"=>$this->operations_count,
            "nationality"=>$this->nationality,
            "address"=>$this->address,
            "gender"=>$this->gender,
            "marital_status"=>$this->marital_status,
//            'added_by_id' => SimpleUserResource::make($this->whenLoaded('addedBy')),
//            'country' => CountryResource::make($this->whenLoaded('country')),
            'managers' => ManagerResource::collection($this->whenLoaded('managers')),
            'user_type' => $this->when(request()->is('*/clients/*'), $this->user_type),
            'client_type' => $this->client_type,
            'ban_reason' => $this->when($request->is('*/customers/*'), $this->ban_reason),
            'identity_number' => $this->when($request->is('*/customers/*'), $this->identity_number),
            'register_status' => $this->when(request()->is('*/customers/*'), $this->register_status),
            'rate_avg' => $this->when(request()->is('*/customers/*'), $this->rate_avg),
            'date_of_birth' => $this->when(request()->is('*/customers/*'), $this->date_of_birth),
            'date_of_birth_hijri' => $this->when(request()->is('*/customers/*'), $this->date_of_birth_hijri),
            'created_at' => $this->created_at,
            'token' => $this->when($this->token, $this->token),
        ];
    }
}
