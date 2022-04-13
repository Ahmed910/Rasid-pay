<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\AttachmentFile;
use Illuminate\Support\Facades\Storage;

class PrivateController extends Controller
{
    public function __construct()
    {
//        $this->middleware("auth:sanctum");
    }

    public function downloadfile($path)
    {
       $path = "files/client/" . $path;
       // $owner = AttachmentFile::where("path", $path)->get()->first()?->attachment?->user?->id;
       // if (!$owner) return response()->json([
       //     'status' => false,
       //     'message' => trans('dashboard.error.not_found'),
       //     'data' => null
       // ], 404);
       // if ((auth()->user() == null) || ($owner != auth()->user()->id && auth()->user()->user_type == "client"))
       //     return response()->json([
       //         'status' => false,
       //         'message' => trans('auth.failed'),
       //         'data' => null
       //     ], 401);
        if (Storage::exists($path)) {
            $filepath = Storage::disk('local')->path($path);
            $headers = array();
            return response()->file($filepath, $headers);
        }
    }
}
