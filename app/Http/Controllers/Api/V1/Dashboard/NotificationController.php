<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\NotificationRequest;
use App\Http\Resources\Dashboard\NotificationResource;
use App\Models\User;
use App\Notifications\generalNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index(Request $request)
    {
        $notifications = auth()->user()->notifications()->latest()->paginate((int)($request->per_page ?? 10));
        return NotificationResource::collection($notifications)
            ->additional([
                'count' => auth()->user()->unreadNotifications()->count(),
                'status' => true,
                'message' =>  '',
            ]);
    }

    public function create()
    {
        //
    }

    public function store(NotificationRequest $request)
    {
        $user = User::when($request->user_list, function ($q) use ($request) {
            $q->whereIn('id', $request->user_list);
        })->where('user_type', $request->type)->get();

        \Notification::send($user, (new generalNotification($request->only(['title', 'body']), ['database']))->onQueue('notifications'));

        return response()->json([
            'status' => true,
            'message' =>  trans('dashboard.general.sent_successfully'),
            'data' => null
        ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    public function updateNotification()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json([
            'status' => true,
            'message' =>  trans('dashboard.general.success_update'),
            'data' => null
        ]);
    }
}
