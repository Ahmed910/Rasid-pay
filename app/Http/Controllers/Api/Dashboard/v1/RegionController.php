<?php

namespace App\Http\Controllers\Api\Dashboard\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboad\Region\RegionRequest;
use App\Http\Resources\Dashboard\RegionResource;
use App\Models\Region\Region;

class regionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return RegionResource|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $region = Region::all()->paginate($request->page ?? 15);
        return RegionResource::collection($region)->additional(['status' => true, 'message' => ""]);
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
        return new (RegionResource($region))->additional(['status' => true, 'message' => ""]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return RegionResource
     */
    public function show(Region $region)
    {
        return new (RegionResource($region))->additional(['status' => true, 'message' => ""]);
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
        $region->update($regionRequest->all());
        return new (RegionResource($region))->additional(['status' => true, 'message' => ""]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        $region->delete();
        return response()->ajax(['status' => true, 'message' => "", 'data' => null]);
    }
}
