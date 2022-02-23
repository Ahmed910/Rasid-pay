<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactReplyResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'admin_id' => $this->admin_id,
            'reply' => $this->reply,
            'created_at' => $this->created_at,
            'contact' =>  ContactResource::make($this->whenLoaded('contact')),
        ];
    }
}
