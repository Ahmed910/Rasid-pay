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
    /**
     * @return WalletResource
     */
    public function index()
    {
        return WalletResource::make(auth()->user()->citizenWallet)->additional(['status' => true, 'message' => '']);
    }

    /**
     * @return WalletResource
     */
    public function fetchWallet()
    {
        $wallet = auth()->user()->citizenWallet;
        $wallet->update([
            'last_updated_at' => now()
        ]);
        return WalletResource::make($wallet)->additional(['status' => true, 'message' => '']);
    }
}
