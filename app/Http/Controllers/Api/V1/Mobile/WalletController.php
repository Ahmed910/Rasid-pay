<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\WalletResource;
use App\Models\CitizenWallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * @return WalletResource
     */
    public function getCitizenWallet()
    {
        $wallet = CitizenWallet::with('user')->firstWhere('citizen_id',auth()->id());
        return WalletResource::make($wallet)->additional(['status' => true, 'message' => '']);
    }
}
