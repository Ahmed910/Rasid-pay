<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

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
        return [

            'user' => SimpleUserResource::make($this->whenLoaded('user')),
            'id' => $this->id,
            "title" => $this->title,
            "attachment_type" => $this->attachment_type,
            "file_type" => $this->file_type,
            "file" => URL::to('/') . "/" . Request::segment(1) . "/" . Request::segment(2) . "/" . Request::segment(3) . "/" . $this->file //TODO handle private url

        ];
    }
}
