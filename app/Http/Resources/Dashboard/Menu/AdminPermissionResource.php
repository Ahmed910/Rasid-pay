<?php

namespace App\Http\Resources\Dashboard\Menu;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminPermissionResource extends JsonResource
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
            'uri' => array_first($this->all())['uri'],
            'actions' => array_column($this->all(),'action')
        ];
    }
}
