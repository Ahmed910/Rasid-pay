<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\VendorRequest;
use App\Http\Resources\Dashboard\VendorResource;
use App\Models\Vendor\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request, Vendor $vendor)
    {
        $vendor->fill($request->validated() + ["added_by" => auth()->id()])->save();
        $vendor->load("images");
        return VendorResource::make($vendor)->additional([
            "status" => true,
            "message" => trans("dashboard.success_add")
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorRequest $request, $id)
    {
        $vendor = Vendor::findorfail($id);
        $vendor->fill($request->validated() + ["updated_at" => now()])->save();
        $vendor->load("translations");
        return VendorResource::make($vendor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
