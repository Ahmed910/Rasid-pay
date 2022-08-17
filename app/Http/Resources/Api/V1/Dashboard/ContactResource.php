<?php

namespace App\Http\Resources\Api\V1\Dashboard;

use Carbon\Carbon;
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
            'contact_type' => $this->messageType->name,
            'message_source' => $this->message_source,
            'message_status' => $this->message_status,
            'notes' => $this->notes,
            'read_at' => $this->read_at,
            'created_at' => now()->diffInDays($this->created_at) > 7 ? $this->created_at_date_time : $this->created_at->diffForHumans(),
            'user' =>  SimpleUserResource::make($this->whenLoaded('user')),
            'admin' =>  SimpleUserResource::make($this->whenLoaded('admin')),
            'replies' => ContactReplyResource::collection($this->whenLoaded('replies')),
        ];
    }
}
