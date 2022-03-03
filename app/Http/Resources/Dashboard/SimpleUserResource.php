<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'user_type' => $this->user_type,
            'date_of_birth' => $this->date_of_birth,
            'created_at' => $this->created_at,
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),

        ];
    }
}
