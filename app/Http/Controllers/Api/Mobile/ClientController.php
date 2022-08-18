<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Resources\Api\Mobile\VendorBranchResource;
use App\Models\VendorBranches\VendorBranch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Mobile\ClientResource;
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
        $client = VendorBranch::where(['is_active' => true])
            ->where(['is_active' => true])
            ->with('vendor')->findOrFail($id);
        return VendorBranchResource::make($client)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

}
