<?php

namespace App\Http\Resources\Dashboard\Group;

use App\Http\Resources\Dashboard\{GlobalTransResource , SimpleUserResource};
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'name' => $this->name,
            'is_active' => (bool)$this->is_active,
            'added_by' => SimpleUserResource::make($this->addedBy),
            'admins_count' => $this->admins->count(),
            'translations' => $this->when(!in_array($request->route()->getActionMethod(),['index','archive']),GlobalTransResource::collection($this->whenLoaded('translations'))),
            'created_at' => $this->created_at,
            'actions' => [
                'update' => auth()->user()->hasPermissions('groups.update'),
                'show' => auth()->user()->hasPermissions('groups.show')
            ]
        ];
    }
}
