<?php

namespace App\Http\Resources;

use App\Http\Resources\Api\V1\Mobile\MessageTypeResource;
use App\Http\Resources\Dashboard\ActivityLogResource;
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
