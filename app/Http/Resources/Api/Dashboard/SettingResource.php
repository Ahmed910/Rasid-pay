<?php

namespace App\Http\Resources\Api\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'key'   => $this->key,
            'value' => $this->value,
            'input' => $this->input_type,
            'is_single' => (bool) $this->is_single,
            'actions' => $this->when($request->routeIs('settings.index'), [
                'update' => auth()->user()->hasPermissions('settings.update')
            ])
        ];
    }
}
