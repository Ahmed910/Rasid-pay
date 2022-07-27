<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Mobile\{HomeResource, WalletResource};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @return WalletResource
     */
    public function index(Request $request)
    {
        if ($request->status_code == 500) {
            return response()->json(['data' => null, 'message' => '', 'status' => 'fail'], 500);
        }
        return HomeResource::make(auth()->user()->citizenWallet)->additional(['status' => true, 'message' => '']);
    }

}
