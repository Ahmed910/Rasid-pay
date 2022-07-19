<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'title' => $this->title,
            'content' => $this->content,
            'message_type' => ['id' => $this->messageType->id, 'name' => $this->messageType->name],
            'message_source' => $this->message_source,
            'message_status' => $this->message_status,
            'notes' => $this->notes,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
            'user' => SimpleUserResource::make($this->whenLoaded('user')),
            'admin' => SimpleUserResource::make($this->whenLoaded('admin')),
            'replies' => ContactReplyResource::collection($this->whenLoaded('replies')),
            'activity' => ActivityLogResource::collection($this->whenLoaded('activity')),
            'actions' => $this->when($request->routeIs('messages.index'), [
                'show' => auth()->user()->hasPermissions('messages.show'),
                'update' => auth()->user()->hasPermissions('messages.update'),
            ])
        ];
    }
}
