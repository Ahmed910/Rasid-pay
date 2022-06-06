<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Auth\UpdatePasswordRequest;
use App\Http\Requests\V1\Mobile\UpdateProfileRequest;
use App\Http\Resources\Mobile\UserResource;
use App\Http\Resources\Mobile\WalletResource;
use App\Models\CitizenWallet;

class HomeController extends Controller
{
    public function index()
    {
        $wallet = CitizenWallet::with('user')->firstWhere('citizen_id',auth()->id());
        return WalletResource::make($wallet)->additional(['status' => true, 'message' => '']);
    }
}
