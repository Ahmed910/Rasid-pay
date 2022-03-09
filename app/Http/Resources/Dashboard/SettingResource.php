<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'key'   => $this->key,
            'value' => $this->value,
            'input' => $this->input_type,
            'actions' => $this->when($request->route()->getActionMethod() == 'index', [
                'update' => auth()->user()->hasPermissions('countries.update')
            ])
        ];
    }
}
