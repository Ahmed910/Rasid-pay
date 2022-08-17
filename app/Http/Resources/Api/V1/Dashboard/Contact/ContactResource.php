<?php

namespace App\Http\Resources\Api\V1\Dashboard\Contact;

use App\Http\Resources\Api\V1\Dashboard\ContactReplyResource;
use App\Http\Resources\Api\V1\Dashboard\SimpleUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'country_code' => substr($this->phone, 0, 3),
            'phone' => substr($this->phone, 3),
            'title' => $this->title,
            'content' => $this->content,
            'message_type' => ['id' => $this->messageType?->id, 'name' => $this->messageType?->name],
            'message_source' => $this->message_source,
            'message_status' => $this->message_status,
            'notes' => $this->notes,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at_date_time,
            'user' => SimpleUserResource::make($this->whenLoaded('user')),
            'admin' => SimpleUserResource::make($this->whenLoaded('admin')),
            'assigned_to' => SimpleUserResource::make($this->whenLoaded('assignedTo')),
            'replies' => ContactReplyResource::collection($this->whenLoaded('replies')),
            // 'activity' => ActivityLogResource::collection($this->whenLoaded('activity')),
            'actions' => $this->when($request->routeIs('contacts.index'), [
                'show' => auth()->user()->hasPermissions('contacts.show'),
                'reply' => auth()->user()->hasPermissions('contacts.reply') && $this->message_status != 'replied' ,
            ]),
            'assign_contact' => $this->when($request->routeIs('contacts.show') || $request->routeIs('contacts.reply'),auth()->user()->hasPermissions('contacts.assign_contact')  && $this->message_status != 'replied')

        ];
    }
}
