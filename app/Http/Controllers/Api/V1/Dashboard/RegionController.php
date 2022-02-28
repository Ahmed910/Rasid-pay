<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Requests\V1\Dashboard\RegionRequest;
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
        $regions = Region::Search($request)
            ->with(['translations' => function ($q) {
                    $q->where('locale', app()->getLocale());
                }])->sortby($request)
            ->latest()
            ->paginate((int)($request->page ?? 15));

        return RegionResource::collection($regions)->additional([
            'status' => true,
            'message' => "",
        ]);
    }

    public function archive(Request $request)
    {
        $regions = Region::onlyTrashed()->sortby($request)->latest()->paginate((int)($request->page ?? 15));
        return RegionResource::collection($regions)->additional([
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
    public function store(RegionRequest $request, Region $region)
    {
        $region->fill($request->validated() + ['added_by_id' => auth()->id()])->save();
        return RegionResource::make($region)->additional([
            'status' => true, 'message' => trans("dashboard.general.success_add")
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return RegionResource
     */
    public function show( $id)
    {
        $region = Region::withTrashed()->findOrFail($id);
        $relations  = ['translations'];
     return RegionResource::make($region->load($relations))->additional(['status' => true, 'message' => ""]);
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

        return RegionResource::make($region)->additional([
            'status' => true, 'message' => trans("dashboard.general.success_update")]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ReasonRequest $request,Region $region)
    {

        if ($region->cities()->exists()) {
            return response()->json([
                'status' => false,
                'message' => trans('dashboard.general.has_relationship_cannot_delete'),
                'data' => null
            ], 422);
        }
        $region->delete();
        return RegionResource::make($region)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_archive'),
            ]);
    }

    public function forceDelete(ReasonRequest $request , $id)
    {
        $region = Region::onlyTrashed()->findOrFail($id);

        $region->forceDelete();

        return RegionResource::make($region)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_delete'),
            ]);

    }

    public function restore(ReasonRequest  $reasonRequest , $id)
    {
        $region = Region::onlyTrashed()->findOrFail($id);
        $region->restore();

        return RegionResource::make($region)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_restore'),
            ]);

    }

}
