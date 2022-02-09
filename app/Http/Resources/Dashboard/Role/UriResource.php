<?php

namespace App\Http\Resources\Dashboard\Role;

use Illuminate\Http\Resources\Json\JsonResource;

class UriResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {   
        return parent::toArray($request);
    }
}
