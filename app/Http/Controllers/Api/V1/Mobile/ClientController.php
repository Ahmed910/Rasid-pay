<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\ClientResource;
use App\Models\User;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->search;
        $clients = User::where(['user_type'=>'client', 'ban_status' => 'active'])->has('clientPackages')->with('clientPackages','client')->when($keyword,function ($query)  use($keyword) {
            $query->where(function ($q) use($keyword) {
                $q->where('fullname', 'like', '%' . $keyword . '%')
                   ->orWhere('email', 'like', '%' . $keyword . '%')
                   ->orWhere('phone', 'like', '%' . $keyword . '%');
               });
            })
        ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return ClientResource::collection($clients)->additional([
            'status'=>true,
            'message'=>''
        ]);

    }

    public function show($id)
    {
        $client = User::has('clientPackages')->where(['user_type'=>'client', 'ban_status' => 'active'])->with('clientPackages','client')->findOrFail($id);
        return
        ClientResource::make($client)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

}
