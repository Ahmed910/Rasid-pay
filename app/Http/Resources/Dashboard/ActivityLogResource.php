<?php

namespace App\Http\Resources\Dashboard;

use Dflydev\DotAccessData\Data;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ActivityLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {

        $model = $this->auditable_type;
        if (str_contains($this->auditable_type, '\\')) {
            $class = explode('\\', $this->auditable_type);
            $model = $class[COUNT($class) - 1];
        };
        return [
            'id' => $this->id,
            'user' => $this->user ? SimpleUserResource::make($this->user) : null,
            'auditable_type' => $model,

            'auditable' => $this->auditable_id ? [
                'id' => $this->auditable?->id,
                'name' => $this->auditable?->name,
                'type' => ($this->auditable) ? get_class($this->auditable) : null
            ] : null,
            'created_at' => $this->created_at,
            'type' => strtolower($this->action_type),
            'reason' => $this->reason ?? trans('dashboard.general.no_reasons'),
            "usertype" => $this->user_type,
            'url' => $this->url,
            'ip' => $this->ip_address,
            'agent' => $this->agent,

            'subprogram' => $this->sub_program,
            'show_route' => route('dashboard.activity_log.show', $this->id),
            'start_from' => $request->start,
            "discription" => trans('dashboard.activity_log.reason', ["user" => $this->user->fullname,
                "model" => trans("dashboard.activity_log.models." . strtolower($model == "User" ? $this->user_type : $model)),
                "action" => trans("dashboard.activity_log.actions." . $this->action_type),
                "main" => trans("dashboard." . Str::snake($this->user_type ? $this->user_type : $model) . "." . str_plural(Str::snake($this->user_type ? $this->user_type : $model)))
            ],
            ),
//            "main" => trans("dashboard." . Str::snake($model) . "." . str_plural(Str::snake($model)))

        ];

        // trans('dashboard.activity_log.reason', [
        //     'user' => $this->user?->fullname,
        //     'action' => trans('dashboard.activity_log.actions.' . $this->action_type),
        //     'model' => trans('dashboard.'.strtolower($this->auditable_type).".".strtolower($this->auditable_type))
        // ])
    }
}
