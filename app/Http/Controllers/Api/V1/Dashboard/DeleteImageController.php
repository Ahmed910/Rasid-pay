<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AppMedia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DeleteImageController extends Controller
{
    public function __invoke(AppMedia $appMedia)
    {
        $appMedia->forceDelete();
        $media = $appMedia->media;

        $path = Str::replace("/storage/", "", $media);

        Storage::disk('public')->delete($path);

        return response()->json(
            [
                'data' => '',
                'status' => true,
                'message' => "",
            ],
            200
        );
    }
}
