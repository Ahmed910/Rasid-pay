<?php

namespace App\Http\Resources\Blade\Dashboard\Group;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Lang;

class GroupResource extends JsonResource
{
    public function toArray($request)
    {
       
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => (bool)$this->is_active,
            // 'added_by' => SimpleUserResource::make($this->addedBy),
            'admins_count' => $this->user_count??trans(''),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'groups' => self::collection($this->whenLoaded('groups')),
            'created_at' => $this->created_at,
            'is_selected' => auth()->user()->groups()->where('groups.id',$this->id)->exists(),
            'active_case' => trans('dashboard.general.active_cases.'.$this->is_active),
            'show_route' => $this->when(auth()->user()->hasPermissions('group.show'), route('dashboard.group.show', $this->id),null),
            'edit_route' => $this->when(auth()->user()->hasPermissions('group.update'), route('dashboard.group.edit', $this->id),null),
            'start_from' => $request->start
        ];
    }
}
