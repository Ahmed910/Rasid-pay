<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ImagesResource extends JsonResource
{
    public function toArray($request)
    {
        $filePath = url('') . $this->media;

        return [
            "id"    => $this->id,
            "media" => (file_exists($filePath)) ? $filePath : asset('dashboardAssets/images/brand/no-img.png'),
            "name"  => $this->option,
        ];
    }
}
