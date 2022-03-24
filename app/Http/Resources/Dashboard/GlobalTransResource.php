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
                'description' => $this->when($this->description, $this->description, null),
                'nationality' => $this->when($this->nationality, $this->nationality, null)
        ];
    }
}
