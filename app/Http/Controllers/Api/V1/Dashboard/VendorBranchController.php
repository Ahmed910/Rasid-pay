<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\VendorBranchRequest;
use App\Models\Vendor\Vendor;
use App\Http\Resources\Dashboard\VendorBranches\VendorBranchCollection;
use App\Http\Resources\Dashboard\VendorBranches\VendorBranchResource;
use Illuminate\Http\Request;
use App\Models\VendorBranches\VendorBranch;

class VendorBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }

        $vendorBranches = VendorBranch::query()
        ->search($request)
        ->sortBy($request)
        ->paginate((int)($request->per_page ?? config("globals.per_page")));

      

        return VendorBranchResource::collection($vendorBranches)->additional([
            'status' => true,
            'message' => ""
        ]);


    }
/**
     * pluck vendors in independent service.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVendors()
    {
       $vendors = Vendor::get()->pluck('name','id');

       return response()->json(['data' => $vendors,'status' =>true,'message' =>'']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorBranchRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $vendorBranch  = VendorBranch::withTrashed()->findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $vendorBranch->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return VendorBranchCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
            ]);
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
    public function destroy(VendorBranch $vendorBranch)
    {
        $vendorBranch->delete();
        return VendorBranchResource::make($vendorBranch)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_delete')
            ]);
    }
}