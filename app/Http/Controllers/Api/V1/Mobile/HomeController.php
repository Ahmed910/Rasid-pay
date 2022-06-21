<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Mobile\{HomeResource, WalletResource};

class HomeController extends Controller
{
    /**
     * @return WalletResource
     */
    public function index()
    {
        return HomeResource::make(auth()->user()->citizenWallet)->additional(['status' => true, 'message' => '']);
        // return WalletResource::make(auth()->user()->citizenWallet)->additional(['status' => true, 'message' => '']);
    }

}
