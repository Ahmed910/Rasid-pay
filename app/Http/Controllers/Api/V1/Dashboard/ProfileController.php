<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Dashboard\ProfileResource;
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
}
