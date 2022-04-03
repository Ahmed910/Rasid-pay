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
            'user' => $this->user ? SimpleUserResource::make($this->user) : null,
            'auditable_type'=> $this->auditable_type ?$this->auditable_type :null,

            'auditable' => $this->auditable_id ? [
                'id' => $this->auditable?->id,
                'name' => $this->auditable?->name,
                'type' => ($this->auditable) ? get_class($this->auditable) : null
            ] : null,
            'created_at' => $this->created_at,
            'type' => strtolower($this->action_type),
            'reason' => $this->reason ?? trans('dashboard.general.no_reasons'),
            'url' => $this->url,
            'ip' => $this->ip_address,
            'agent' => $this->agent,

            'subprogram'  => $this->sub_program,
            'show_route' => route('dashboard.activity_log.show', $this->id),

        ];

        // trans('dashboard.activity_log.reason', [
        //     'user' => $this->user?->fullname,
        //     'action' => trans('dashboard.activity_log.actions.' . $this->action_type),
        //     'model' => trans('dashboard.'.strtolower($this->auditable_type).".".strtolower($this->auditable_type))
        // ])
    }
}
