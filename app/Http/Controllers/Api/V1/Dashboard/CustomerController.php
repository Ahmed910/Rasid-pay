<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\CustomerRequest;
use App\Http\Resources\Dashboard\CustomerResource;
use App\Http\Resources\Dashboard\RegionResource;
use App\Models\Region\Region;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = ['company' , 'Institution' , 'member' , 'freelance_doc' , 'famous' , 'other'] ;
        $user = User::whereIn("client_type"  , $types)->latest()->paginate((int)($request->page ?? 15));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request , User $user)
    {
        $user->fill($request->validated())->save();
        return (new CustomerResource($user))->additional([
            'status' => true, 'message' => trans("dashboard.general.success_add")
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::withTrashed()->findorfail($id);
        return (new CustomerRequest($user))->additional(['status' => true, 'message' => ""]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
