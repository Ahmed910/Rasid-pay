<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Http\Resources\Dashboard\MessageTypeResource;
use App\Models\MessageType\MessageType;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MessageTypeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $messageType = MessageType::withCount('admins')->with('admins', 'activity')->findOrFail(@$request->route()->parameters['message_type']);

        return [
            'message_type' => MessageTypeResource::make($messageType),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
