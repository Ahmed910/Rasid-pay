<?php

namespace App\Http\Resources\Dashboard\Menu;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MenuCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $permissions = @auth()->user()->role->permissions->map(function($item){
            $action = explode('.',$item->name);
            $data['uri'] = $action[0];
            $data['action'] = $action[1];
            return $data;
        })->groupBy('uri')->values();
        return[
            'menu' => MenuResource::collection($this->collection),
            'permissions' => AdminPermissionResource::collection($permissions),
        ];
    }
}
