<?php

namespace App\Http\Resources\Dashboard\Menu;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $children = $this->children->filter(function($item){
            if ($item->uri == 'create') {
                return auth()->user()->hasPermissions($this->uri,['store','create','add']);
            }else{
                return auth()->user()->hasPermissions($this->uri,[$item->uri,'update','show','archive','edit','record','list']);
            }
        })->sortBy('order');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'uri' => $this->uri,
            'order' => $this->order,
            'icon' => $this->icon,
            'children' => $this->when($children->count() , self::collection($children)),
        ];
    }
}
