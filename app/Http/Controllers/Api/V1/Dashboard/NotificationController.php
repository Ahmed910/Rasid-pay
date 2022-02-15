<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\NotificationResource;
use App\Models\Notification as notificationModel;
use App\Models\User;
use App\Notifications\generalNotification;
use Illuminate\Http\Request;
use Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $notifications = auth()->user()->notifications()->latest()->paginate((int)($request->perPage ?? 10));
        return NotificationResource::collection($notifications)
            ->additional([
                'count' => auth()->user()->unreadNotifications()->count(),
                'status' => true,
                'message' =>  '',
            ]);
            // auth()->user()->unreadNotifications->markAsRead();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::when($request->user_list, function ($q) use ($request) {
            $q->whereIn('id', $request->user_list);
        })->where('user_type', $request->type)->get();

        $notificationData = [
            'title' => $request->title,
            'body' => $request->body,
        ];

        Notification::send($user, (new generalNotification($notificationData, ['database']))->onQueue('notifications'));

        return response()->json([
            'status' => true,
            'message' =>  trans('dashboard.general.sent_successfully'),
            'data' => ''
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
