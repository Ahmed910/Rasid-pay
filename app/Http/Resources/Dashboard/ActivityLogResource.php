<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => SimpleUserResource::make($this->whenLoaded('user')),
            // 'auditable' => AuditableResource::make($this->whenLoaded('auditable')),
            'created_at' => $this->created_at,
            'type' => $this->action_type,
            'reason' => trans('dashboard.activity_log.reason',['user'=>$this->id,'action'=>$this->action_type]),
            'url' => $this->url,
            'ip' => $this->ip_address,
            'agent' => $this->agent,
        ];
    }
}
