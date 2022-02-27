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
            "Commercial_number" => $this->Commercial_number,
            "tax_number" => $this->tax_number,
            "bank_account_number" => $this->bank_account_number,
            "activity_type" => $this->activity_type,
            "operations_count" => $this->operations_count,
            "nationality" => $this->nationality,
            "address" => $this->address,
            "gender" => $this->gender,
            "marital_status" => $this->marital_status,
            'user' => UserResource::make('user'),
//            'managers' => ManagerResource::make($this->whenLoaded('manager')),
            'client_type' => $this->client_type,
            'date_of_birth' =>  $this->date_of_birth,
            'created_at' => $this->created_at,
            'token' => $this->when($this->token, $this->token),
            'actions' => [
                'show' => auth()->user()->hasPermissions('clients.show'),
                'create' => auth()->user()->hasPermissions('clients.create'),
                'update' => auth()->user()->hasPermissions('clients.update'),
                'restore' => auth()->user()->hasPermissions('clients.restore'),
                'destroy' => auth()->user()->hasPermissions('clients.destroy'),
            ]
        ];
    }
}
