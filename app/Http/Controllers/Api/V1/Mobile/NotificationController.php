<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\{NotificationCollection,NotificationResource};
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = auth()->user()->notifications()->paginate((int)($request->per_page ?? config("globals.per_page")));
        auth()->user()->update(['is_red_notifications' => true]);
        return NotificationCollection::make($notifications)->additional([
            'status'=>true,
            'message'=>''
         ]);
    }

    public function show(Request $request,$id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return NotificationResource::make($notification)->additional([
            'status'=>true,
            'message'=>''
         ]);
    }


}
