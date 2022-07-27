<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'key'   => $this->key,
            'translation' => trans('dashboard.links.'.$this->key),
            'static_page_id' => $this->static_page_id,
            'actions' => $this->when($request->routeIs('links.index'), [
                'update' => auth()->user()->hasPermissions('links.update'),
            ])
        ];
    }
}
