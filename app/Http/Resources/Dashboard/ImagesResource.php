<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ImagesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"    => $this->id,
            "media" => (file_exists(url('') . $this->media)) ? url('') . $this->media : asset('dashboardAssets/images/brand/no-img.png'),
            "name"  => $this->option,
        ];
    }
}
