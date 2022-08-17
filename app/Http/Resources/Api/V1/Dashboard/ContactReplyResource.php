<?php

namespace App\Http\Resources\Api\V1\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactReplyResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'reply' => $this->reply,
            'created_at' => $this->created_at_date_time,
            'admin' =>  SimpleUserResource::make($this->whenLoaded('admin')),
            // 'contact' =>  ContactResource::make($this->whenLoaded('contact')),
        ];
    }
}
