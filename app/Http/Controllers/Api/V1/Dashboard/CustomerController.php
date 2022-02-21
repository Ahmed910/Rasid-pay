<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\CustomerRequest;
use App\Http\Resources\Dashboard\CustomerResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::where("user_type", 'client')->search($request)->latest()->paginate((int)($request->page ?? 15));
        return CustomerResource::collection($user)->additional([
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

    public function archive(Request $request)
    {
        $users = User::where("user_type", 'client')->onlyTrashed()->latest()->paginate((int)($request->perPage ?? 10));
        return CustomerResource::collection($users)
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
    public function store(CustomerRequest $request, User $user)
    {
        $user->fill($request->validated())->save();
        return CustomerResource::make($user)->additional([
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
        return CustomerResource::make($user)->additional(['status' => true, 'message' => ""]);
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
    public function update(CustomerRequest $request, User $customer)
    {
        $customer->fill($request->validated())->save();
        return CustomerResource::make($customer)->additional([
            'status' => true, 'message' => trans("dashboard.general.success_update")
        ]);
    }

    public function forceDestroy($id)
    {
        $user = User::onlyTrashed()->findorfail($id);
        $user->forceDelete();

        return CustomerResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_delete'),
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return CustomerResource
     */
    public function destroy(User $user)
    {

        $user->delete();

        return CustomerResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_archive'),
            ]);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return CustomerResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_restore'),
            ]);
    }
}
