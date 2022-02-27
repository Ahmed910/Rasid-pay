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
            'actions' => [
                'index' => auth()->user()->hasPermissions('settings.index'),
                'update' => auth()->user()->hasPermissions('settings.store')
            ]
        ];
    }
}
