<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\ClientRequest;
use App\Http\Resources\Dashboard\ClientResource;
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
        $user = User::where("user_type", 'client')->search($request)->latest()->paginate((int)($request->page ?? 15));
        return ClientResource::collection($user)->additional([
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

    public function suspendedclients(Request $request)
    {
        $users = User::where(["user_type"=>'client',"is_admin_active_user"=> 0])->latest()->paginate((int)($request->perPage ?? 10));
        return ClientResource::collection($users)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request, User $user)
    {
        $user->fill($request->validated())->save();
        return ClientResource::make($user)->additional([
            'status' => true, 'message' => trans("dashboard.general.success_add")
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::withTrashed()->findorfail($id);
        return ClientResource::make($user)->additional(['status' => true, 'message' => ""]);
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
    public function update(ClientRequest $request, User $customer)
    {
        $customer->fill($request->validated())->save();
        return ClientResource::make($customer)->additional([
            'status' => true, 'message' => trans("dashboard.general.success_update")
        ]);
    }

    public function forceDestroy($id)
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
    public function destroy(User $user)
    {

        $user->delete();

        return ClientResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_archive'),
            ]);
    }

    public function suspend($id)
    {
        $user = User::findorfail($id);
        $user->update(["is_admin_active_user" => 0]);

        return ClientResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_suspend'),
            ]);
    }

    public function restore($id)
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
