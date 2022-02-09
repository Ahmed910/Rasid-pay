<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiMasterRequest;
use App\Http\Requests\V1\Dashboad\RegionRequest;
use App\Http\Resources\Dashboard\RegionResource;
use App\Models\Region\Region;
use Illuminate\Http\Request;


class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return RegionResource|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $region = Region::latest()->paginate((int)($request->page ?? 15));
        return RegionResource::collection($region)->additional([
            'status' => true,
            'message' => ""
        ]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RegionResource
     */
    public function store(RegionRequest $regionRequest)
    {
        $region = Region::create($regionRequest->all());
        return (new RegionResource($region))->additional([
            'status' => true, 'message' => trans("dashboard.general.success_add")
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return RegionResource
     */
    public function show($id)
    {
        $region = Region::withtrashed()->findorfail($id);
        return (new RegionResource($region))->additional(['status' => true, 'message' => ""]);
    }

    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return RegionResource
     */
    public function update(RegionRequest $regionRequest, Region $region)
    {
        $region->update($regionRequest->validated());
        return (new RegionResource ($region))->additional([
            'status' => true, 'message' => trans("dashboard.general.success_update")]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Region $region)
    {
        $region->delete();
        return response()->json(['status' => true, 'message' => trans("dashboard.general.success_delete"), 'data' => null]);
    }

    public function forceDelete($id)
    {
        $region = Region::withTrashed()->findorfail($id);

        $region->forceDelete();
        return response()->json(['status' => true, 'message' => trans("dashboard.general.force_delete"), 'data' => null]);

    }

    public function restore(Region $region)
    {
        $region->restore();
        return response()->json(['status' => true, 'message' => trans("dashboard.general.restore"), 'data' => null]);

    }

}
