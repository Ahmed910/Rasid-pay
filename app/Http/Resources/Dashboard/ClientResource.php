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
        $map = [null => null, "company" => "شركات", "institution" => "مؤسسة", "other" => "أخري", "member" => "عضو", "freelance_doc" => "مستقل", "famous" => "مشهور"];
        return [
            'user' => SimpleUserResource::make($this->whenLoaded('user')),
            "tax_number" => $this->tax_number,
            "commercial_number" => $this->commercial_number,
            "bank_account_number" => $this->bank_account_number,
            "activity_type" => $this->activity_type,
            "daily_expect_trans" => $this->daily_expect_trans,
            "nationality" => $this->nationality,
            "address" => $this->address,
            "marital_status" => $this->marital_status,
            'client_type' => ["ar" => $map[$this->client_type], "en" => $this->client_type],
            "register_type" => $this->register_type,
            "transactions_done" => isset($this->transactions_done) ? $this->transactions_done : 0,
            'created_at' => $this->created_at,
            'token' => $this->when($this->token, $this->token),
            'managers' => ManagerResource::collection($this->whenLoaded('managers')),

            'actions' => $this->when($request->routeIs('clients.index') || $request->routeIs('clients.archive'), [
                'show' => auth()->user()->hasPermissions('clients.show'),
                $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                    'create' => auth()->user()->hasPermissions('clients.store'),
                    'update' => auth()->user()->hasPermissions('clients.update')
                ])
            ])
        ];
    }
}
