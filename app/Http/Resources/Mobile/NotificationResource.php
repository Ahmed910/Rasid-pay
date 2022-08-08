<?php

namespace App\Http\Resources\Mobile;

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
            'title' => @$this->data['title'],
            'body' => @$this->data['body'],
            'notify_type' => @$this->data['notify_type'] ?? 'management',
            'created_at' => $this->created_at->diffForHumans(),
            'read_at' => optional($this->read_at)->format("Y-m-d H:i"),
            'logo' => setting('logo')
        ];

    }
}
