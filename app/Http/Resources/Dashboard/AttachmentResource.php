<?php

namespace App\Http\Resources\Dashboard;

use Faker\Core\File;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
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
        //TODO handle private url
        $res = json_decode($this->file);
        $final = [];
        if (isset($this->file) && isset($res)) foreach ($res as $item) {
            $final[] = URL::to('/') . "/" . Request::segment(1) . "/" . Request::segment(2) . "/" . Request::segment(3) . "/" . $item;
//            $fi[] = Storage::disk('local')->path($item);
        }
        return [

            'user' => SimpleUserResource::make($this->whenLoaded('user')),
            'id' => $this->id,
            "title" => $this->title,
            "attachment_type" => $this->attachment_type,
            "file_type" => $this->file_type,
            "file" => $final,
        ];
    }
}
