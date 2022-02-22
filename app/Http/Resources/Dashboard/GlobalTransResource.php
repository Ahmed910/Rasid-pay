<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class GlobalTransResource extends JsonResource
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
            'locale' => $this->locale,
            'name' => $this->name,
            'desc' => $this->when(array_key_exists('desc', $this->getAttributes()), $this->desc),
            'description' => $this->when(array_key_exists('description', $this->getAttributes()), $this->description),
            'nationality' => $this->when(array_key_exists('nationality', $this->getAttributes()), $this->nationality),
        ];
    }
}
