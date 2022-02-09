<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiMasterRequest;
use App\Http\Requests\V1\Dashboad\RegionRequest;
use App\Http\Resources\Dashboard\CountryResource;
use App\Http\Resources\Dashboard\RegionResource;
use App\Models\Country\Country;
use App\Models\Region\Region;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


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
    public function archive(Request $request)
    {
        $region = Region::onlyTrashed()->latest()->paginate((int)($request->page ?? 15));
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
    public function store(RegionRequest $request,Region $region)
    {
        $region->fill($request->validated())->save();
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
        $region = Region::withTrashed()->findorfail($id);
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
    public function update(RegionRequest $request, Region $region)
    {
        $region->fill($request->validated())->save();

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

        if ($region->cities()->exists()) {
            return response()->json([
                'status' => false,
                'message' =>  trans('dashboard.general.has_relationship_cannot_delete'),
                'data' => null
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $region->delete();

        return RegionResource::make($region)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_archive'),
            ]);
    }

    public function forceDelete($id)
    {
        $region = Region::onlyTrashed()->findorfail($id);

        $region->forceDelete();

        return RegionResource::make($region)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_delete'),
            ]);

    }

    public function restore($id)
    {
        $region = Region::onlyTrashed()->findOrFail($id);
        $region->restore();

        return CountryResource::make($region)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_restore'),
            ]);

    }

}
