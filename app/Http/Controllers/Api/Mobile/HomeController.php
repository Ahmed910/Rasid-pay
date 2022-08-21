<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Mobile\{HomeResource, WalletResource};
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
        auth()->user()?->citizenWallet->update([
            'last_updated_at' => now()
        ]);
        return HomeResource::make(auth()->user()->citizenWallet)->additional(['status' => true, 'message' => '']);
    }

}
