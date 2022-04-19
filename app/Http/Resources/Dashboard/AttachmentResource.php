<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $map = [null => null, "other" => "أخري", "images" => "صور", "docs" => "المستندات", "identity" => "هوية", "videos" => "فديو", 'voices' => "صوتيات", "delegate" => "مفوض"];
        //TODO handle private url
        return [

            'user' => SimpleUserResource::make($this->whenLoaded('user')),
            'id' => $this->id,
            "title" => $this->title,
            "attachment_type" => ["en" => $this->attachment_type, "ar" => $map[$this->attachment_type]],
            "files" => AttachmentFileResource::collection($this->whenLoaded('attachmentfiles')),
        ];
    }
}
