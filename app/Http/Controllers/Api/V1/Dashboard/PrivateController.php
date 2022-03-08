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
        $owner = Attachment::where("file", $path)->pluck("user_id");
        if ($owner != auth()->user()->id && auth()->user()->user_type == "client")
            return response()->json([
                'status' => false,
                'message' => trans('auth.failed'),
                'data' => null
            ], 401);
        if (Storage::exists($path)) {
            return Storage::download($path);
        }
    }
}
