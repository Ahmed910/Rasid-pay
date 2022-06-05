<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\ActivateNotifcationRequest;
use App\Http\Requests\V1\Mobile\Auth\UpdatePasswordRequest;
use App\Http\Requests\V1\Mobile\UpdateProfileRequest;
use App\Http\Resources\Mobile\UserResource;

class ProfileController extends Controller
{
    public function index()
    {
        return UserResource::make(auth()->user())->additional(['status' => true, 'message' => '']);
    }

    public function store(UpdateProfileRequest $request)
    {
        $client = auth()->user();
        $client->fill($request->validated())->save();
        $client->citizen()->update($request->only(['lat', 'lng', 'location']));
        $client->bankAccount()->update(['account_number' => $request->account_number]);
        return UserResource::make(auth()->user())->additional(['status' => true, 'message' => trans('dashboard.general.success_update')]);
    }

    /**
     * @param UpdatePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        auth()->user()->update([
            'password' => $request->new_password
        ]);
        return response()->json([
            'status' => true,
            'message' => trans('auth.success_update_password'),
            'data' => null,
        ]);
    }


    /**
     * @param ActivateNotifcationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
     public function activateNotifcation(ActivateNotifcationRequest $request)
    {
        auth()->user()->update([
            'is_notification' => $request->is_notification
        ]);
        return response()->json([
            'status' => true,
            'message' => trans('auth.success_activate_notifcation'),
            'data' => null,
        ]);
    }
}
