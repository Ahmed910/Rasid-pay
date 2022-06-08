<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\ClientRequest;
use App\Http\Resources\Mobile\ClientResource;
use App\Models\User;

class ClientController extends Controller
{
    public function index(ClientRequest $request)
    {
        $keyword = $request->search;
        $clients = User::where(['user_type'=>'client','is_active'=>true])->when($keyword,function ($query)  use($keyword) {
            $query->where(function ($q) use($keyword) {
                $q->where('fullname', 'like', '%' . $keyword . '%')
                   ->orWhere('email', 'like', '%' . $keyword . '%')
                   ->orWhere('phone', 'like', '%' . $keyword . '%');
               });
            })
        ->get();
        return ClientResource::collection($clients)->additional([
            'status'=>true,
            'message'=>''
        ]);

    }

    public function show($id)
    {
        $client = User::with('package')->findOrFail($id);

        return
        ClientResource::make($client)->additional(['status' => true, 'message' => ""]);
    }

}
