<?php

namespace App\Http\Resources\Dashboard;

use App\Models\ActivityLog;
use App\Models\Currency\Currency;
use App\Models\Faq\Faq;
use App\Models\Transaction;
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

        if ($this->auditable?->name) {
            $name = $this->auditable?->name;
        } elseif ($model == 'Contact') {
            $name = trans('dashboard.contact.name');
        } elseif ($model == class_basename(Transaction::class)) {
            $name = $this->auditable?->trans_status;
        } elseif ($model == class_basename(Faq::class)) {
            $name = $this->auditable?->question;
        } elseif ($model == class_basename(Currency::class)) {
            $name = $this->auditable?->countries?->name;
        } else {
            $name = $this->auditable?->fullname;
        }

        return [
            'id' => $this->id,
            'user' => $this->user ? SimpleUserResource::make($this->user) : null,
            'auditable_type' => $model,

            'auditable' => $this->auditable_id ? [
                'id' => $this->auditable?->id,
                'name' =>  $name,
                'type' => ($this->auditable) ? get_class($this->auditable) : null
            ] : null,
            'created_at' => $this->created_at_date_time,
            'type' => strtolower($this->action_type),
            'reason' => $this->reason ?? trans('dashboard.general.no_reasons'),
            "usertype" => $this->user_type,
            'url' => $this->url,
            'ip' => $this->ip_address,
            'agent' => $this->agent,

            'mainprogram' => trans("dashboard." . Str::snake($model) . "." . str_plural(Str::snake($model))),
            'subprogram' => $this->sub_program,
            'trans_sub_progrm' => trans("dashboard.permissions." . $this->sub_program),
            'show_route' => route('dashboard.activity_log.show', $this->id),
            'start_from' => $request->start,
            "discription" => trans(
                'dashboard.activity_log.reason',
                [
                    "model" => trans("dashboard.activity_log.models." . strtolower($this->user_type ? $this->user_type : $model)),
                    'name' => $this->action_type == ActivityLog::SEARCH ? $this->getSearchParam($this->search_params) : $name,
                    "action" => trans("dashboard.activity_log.actions." . $this->action_type),
                    // "main" => trans("dashboard." . Str::snake($this->user_type ? $this->user_type : $model) . "." . str_plural(Str::snake($this->user_type ? $this->user_type : $model)))
                    // , "sub" => trans("dashboard.permissions." . $this->sub_program)
                ],
            ),
            'actions' => $this->when($request->routeIs('activity_logs.index'), [
                'show' => auth()->user()->hasPermissions('activity_logs.show'),
            ])
        ];

        // trans('dashboard.activity_log.reason', [
        //     'user' => $this->user?->fullname,
        //     'action' => trans('dashboard.activity_log.actions.' . $this->action_type),
        //     'model' => trans('dashboard.'.strtolower($this->auditable_type).".".strtolower($this->auditable_type))
        // ])
    }

    public function  getSearchParam($search_params)
    {
        foreach ($search_params as $key => $value) {
            is_array($value)?? (implode('-',  $value));
            $newData[] = trans('validation.attributes.' . $key) . '=' . $value;
        }
        return (implode(',',  $newData));
    }
}
