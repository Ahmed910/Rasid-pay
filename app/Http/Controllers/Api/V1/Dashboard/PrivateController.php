<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class PrivateController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function downloadfile($path)
    {
        $path = "files/client/" . $path;
        $owner = Attachment::where("file", $path)->pluck("user_id") ?? [0];
        if ($owner != auth()->user()->id && auth()->user()->user_type == "client")
            return response()->json([
                'status' => false,
                'message' => trans('auth.failed'),
                'data' => null
            ], 401);
        if (Storage::exists($path)) {
            $filepath = Storage::disk('local')->path($path);
            $headers = array();
            return response()->file($filepath, $headers);
        }
    }
}
