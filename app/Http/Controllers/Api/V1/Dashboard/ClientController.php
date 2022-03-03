<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\ClientRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\ClientResource;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        DB::enableQueryLog();
        $vart = Client::CustomSearch($request)->where('tax_number','01599488204')->latest()->paginate((int)($request->per_page ?? 15));
//         dd($vart);
       dd(DB::getQueryLog()) ;
        // $client = Client::with("user")->search($request)->latest()->paginate((int)($request->per_page ?? 15));

        return ClientResource::collection($vart)->additional([
            'status' => true,
            'message' => ""
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

//    public function suspendedclients(Request $request)
//    {
//        $users = User::where(["user_type" => 'client', "is_admin_active_user" => 0])->latest()->paginate((int)($request->per_page ?? 10));
//        return ClientResource::collection($users)
//            ->additional([
//                'status' => true,
//                'message' => ''
//            ]);
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request, User $user)
    {
        $except = ["tax_number" , "commercial_number","activity_type","daily_expect_trans","register_type","client_type" , "nationality" ,"address" ,"marital_status"];
        $user->fill($request->safe()->except($except) + ["user_type" => "client",'added_by_id' => auth()->id()])->save();
        $client = Client::create($request->safe()->only($except) + ['user_id' => $user->id]);
        $client->load('user');
        return ClientResource::make($client)->additional([
            'status' => true, 'message' => trans("dashboard.general.success_add")
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $client = Client::where('user_id', $id)->firstOrFail();
        $client->load("user");
        return ClientResource::make($client)->additional(['status' => true, 'message' => ""]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id )
    {
        $client = Client::where('user_id', $id)->firstOrFail();
        $except = ["tax_number" , "commercial_number","activity_type","daily_expect_trans","register_type","client_type" , "nationality" ,"address" ,"marital_status"];
        $client->user()->update($request->safe()->except($except));
        $client->update($request->safe()->only($except));
        $client->load('user');
        return ClientResource::make($client)->additional([
            'status' => true, 'message' => trans("dashboard.general.success_update")
        ]);
    }

    public function forceDestroy(ReasonRequest $request, $id)
    {
        $user = User::onlyTrashed()->findorfail($id);
        $user->forceDelete();

        return ClientResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_delete'),
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return ClientResource
     */
    public function destroy(ReasonRequest $request, User $user)
    {

        $user->delete();

        return ClientResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_archive'),
            ]);
    }


    public function restore(ReasonRequest $request, $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return ClientResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_restore'),
            ]);
    }
}
