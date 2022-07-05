<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\SimpleUserResource;
use App\Http\Resources\Dashboard\ContactReplyResource;

class ContactResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'type' => $this->type? trans("dashboard.contact.types.{$this->type}") : "",
            'title' => $this->title,
            'content' => $this->content,
            'contact_type' => $this->contact_type,
            'message_source' => $this->message_source,
            'message_status' => $this->message_status,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
            'user' =>  SimpleUserResource::make($this->whenLoaded('user')),
            'replies' => ContactReplyResource::collection($this->whenLoaded('replies')),
        ];
    }
}
