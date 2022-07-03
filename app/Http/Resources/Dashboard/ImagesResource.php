<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImagesResource extends JsonResource
{
    public function toArray($request)
    {
        $filePath = $this->media;

        return [
            "id"    => $this->id,
            "media" => Storage::disk('public')->exists(Str::replace("/storage", "", $filePath))
                ? url($filePath)
                : asset('dashboardAssets/images/brand/no-img.png'),
            "name"  => $this->option,
        ];
    }
}
