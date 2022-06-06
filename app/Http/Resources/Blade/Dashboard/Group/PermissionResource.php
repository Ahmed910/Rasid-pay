<?php

namespace App\Http\Resources\Blade\Dashboard\Group;

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
        
        $permission = explode('.',$this->name);
        $single_uri = str_singular($permission[0]);
        $main_prog = trans('dashboard.' . $single_uri . '.' . $permission[0]);
        $action = trans('dashboard.' . $single_uri . '.permissions.' . @$permission[1]);
        $sub_prog = '---';
        switch ($permission) {
            case in_array(@$permission[1],['update','show','destroy']):
                $sub_prog = trans('dashboard.'.$single_uri.'.sub_progs.index');
                break;
            case in_array(@$permission[1],['restore','force_delete']):
                $sub_prog = trans('dashboard.'.$single_uri.'.sub_progs.archive');
                break;
        }
        return [
            'id' => $this->id,
            'is_selected' => auth()->user()->permissions()->where('permissions.id',$this->id)->exists(),
            'main_prog' => $main_prog,
            'sub_prog' => $sub_prog,
            'action' => $action,
            'uri' => $this->name,
            'name' => $main_prog . ' (' . $action . ')',
            'created_at' => $this->created_at
        ];
    }
}
