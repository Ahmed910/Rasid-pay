<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'type' => $this->notifiable_type,
            'data' => $this->data,
            'read_at' => optional($this->read_at)->format('Y-m-d h:i a'),
            'created_at' =>   $this->created_at->format('Y-m-d h:i a'),
        ];
    }
}
