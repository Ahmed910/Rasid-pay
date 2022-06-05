<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationResource extends ResourceCollection
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
            'is_red_notifications' => (bool)auth()->user()->is_red_notifications,
            'unreadnotifications_count' => (int)auth()->user()->unreadnotifications->count(),
            'notifications' => NotificationResource::collection($this->collection)
        ];
    }
}
