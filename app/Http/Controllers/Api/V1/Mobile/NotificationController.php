<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\SlideResource;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = auth()->user()->notifications()->paginate((int)($request->per_page ?? config("globals.per_page")));
        return NotificationResource::make($notifications)->additional(
            ['status'=>true,
            'message'=>'']);
    }


}
