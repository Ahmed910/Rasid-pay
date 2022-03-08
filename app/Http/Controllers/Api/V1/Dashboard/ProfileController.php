<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\ChangePasswordRequest;
use App\Http\Resources\Dashboard\ProfileResource;
use App\Http\Requests\V1\Dashboard\ProfileRequest;

class ProfileController extends Controller
{

    public function show()
    {
        $user = auth()->user();

        return ProfileResource::make($user)
            ->additional([
                "status" => true,
                "message" => ''
            ]);
    }


    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        $user->fill($request->validated()+['updated_at'=>now()])->save();

        return ProfileResource::make($user)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_update')
            ]);
    }


    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        $user->fill($request->validated()+['updated_at'=>now()])->save();

        return ProfileResource::make($user)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_update')
            ]);
    }
}
