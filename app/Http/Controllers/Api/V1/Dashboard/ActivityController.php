<?php

namespace App\Http\Controllers\Api\V1\Dashboard;
use App\Models\ActivityLog;
use App\Http\Resources\Dashboard\ActivityLogResource;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $activatyLogs = ActivityLog::latest()->paginate((int)($request->per_page ?? 15));

        return ActivityLogResource::collection($activatyLogs)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function show()
    {

    }

}
