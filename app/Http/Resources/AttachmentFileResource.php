<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
class AttachmentFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "attachment_id" =>$this->attachment_id,
            "type"=>$this->type ,
            "path"=>URL::to('/') . "/" . Request::segment(1) . "/" . Request::segment(2) . "/" . Request::segment(3) . "/" .$this->path,
        ];
    }
}
