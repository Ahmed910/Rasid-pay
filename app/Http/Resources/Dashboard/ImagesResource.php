<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ImagesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "media" => url('') . $this->media,
            "name"  => $this->option,
        ];
    }
}
