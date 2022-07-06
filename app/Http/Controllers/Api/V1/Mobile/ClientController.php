<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Resources\Api\V1\Mobile\VendorBranchResource;
use App\Models\VendorBranches\VendorBranch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Mobile\ClientResource;
use App\Models\User;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = VendorBranch::where(['is_active' => true])->with("vendor")
            ->search($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));
        return VendorBranchResource::collection($clients)->additional([
            'status' => true,
            'message' => ''
        ]);

    }

    public function show($id)
    {
        $client = User::has('clientPackages')->where(['user_type'=>'client', 'ban_status' => 'active'])->with('clientPackages','client')->findOrFail($id);
        return ClientResource::make($client)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

}
