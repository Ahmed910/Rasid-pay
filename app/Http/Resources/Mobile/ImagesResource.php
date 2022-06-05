<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class ImagesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"    => $this->id,
            "media" => url('') . $this->media,
            "name"  => $this->option,
        ];
    }
}
