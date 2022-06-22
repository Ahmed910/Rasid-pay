<?php

namespace App\Http\Resources\Dashboard\Group;

use App\Http\Resources\Dashboard\GlobalTransResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'is_selected' => auth()->user()->permissions()->where('permissions.id', $this->id)->exists(),
            'main_prog' => $this->main_program_trans,
            'sub_prog' => $this->sub_program_trans,
            'action' => $this->action_trans,
            'uri' => $this->name,
            'name' => $this->main_program_trans . ' (' . $this->action_trans . ')',
            'created_at' => $this->created_at
        ];
    }
}
