<?php

namespace App\Http\Resources\Api\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleUserResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fullname' => $this->fullname ?? '',
            'country_code' => substr($this->phone, 0, 3),
            'phone' => substr($this->phone, 3),
            "gender" => $this->gender,
            'user_type' => $this->user_type,
            'date_of_birth' => $this->date_of_birth,
            'images' => ImagesResource::collection($this->whenLoaded('images')),
            'created_at' => $this->created_at_date,
            'attachments' => !$this->relationLoaded("attachments") ? AttachmentResource::collection($this->whenLoaded('attachments')) : collect(AttachmentResource::collection($this->whenLoaded('attachments'))),
            'bank_account' => BankAccountResource::make($this->whenLoaded('bankAccount')),
            'department' => $this->department ? [
                'id' => $this->department->id,
                'name' => $this->department->name,
                'images' => ImagesResource::collection($this->department?->images),
            ] : null,

        ];
    }
}
