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
        $allAttributes = $this->getAttributes();
        return [
            'id' => $this->id,
            'locale' => $this->locale,
            'name' => $this->name,
            'description' => $this->when(array_key_exists('description', $allAttributes), $this->description),
            'nationality' => $this->when(array_key_exists('nationality', $allAttributes), $this->nationality),
            'value'       => $this->when(array_key_exists('value', $allAttributes), $this->value),
        ];
    }
}
