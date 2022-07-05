<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\TransferPurposeRequest;
use App\Http\Resources\Dashboard\TransferPurpose\TransferPurposeResource;
use App\Models\TransferPurpose\TransferPurpose;
use Illuminate\Http\Request;

class TransferPurposeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransferPurposeRequest $request)
    {
        $transfer_purpose = TransferPurpose::create($request->validated());
        return TransferPurposeResource::make($transfer_purpose)->additional([
            'message' => trans('dashboard.general.success_add'),
            'status' => true
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransferPurposeRequest $request,TransferPurpose $transfer_purpose)
    {
        $transfer_purpose->update($request->validated());
        return TransferPurposeResource::make($transfer_purpose)->additional([
            'message' => trans('dashboard.general.success_update'),
            'status' => true
        ]);
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
