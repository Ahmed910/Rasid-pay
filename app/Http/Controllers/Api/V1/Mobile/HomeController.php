<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\{UpdateProfileRequest, Auth\UpdatePasswordRequest};
use App\Http\Resources\Api\V1\Mobile\{UserResource, WalletResource};
use App\Models\CitizenWallet;

class HomeController extends Controller
{
    /**
     * @return WalletResource
     */
    public function index()
    {
        return WalletResource::make(auth()->user()->citizenWallet)->additional(['status' => true, 'message' => '']);
    }

}
