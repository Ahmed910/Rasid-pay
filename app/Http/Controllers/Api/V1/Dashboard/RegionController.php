<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Requests\V1\Dashboard\RegionRequest;
use App\Http\Resources\Dashboard\Regions\RegionResource;
use App\Http\Resources\Dashboard\Regions\RegionCollection;
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
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return RegionResource::collection($regions)->additional([
            'status' => true,
            'message' => "",
        ]);
    }

    public function archive(Request $request)
    {
        $regions = Region::onlyTrashed()->sortby($request)->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));
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
    public function show( Request $request, $id)
    {
        $region = Region::withTrashed()->with('translations')->findOrFail($id);
        $activities  = $region->activity()
        ->sortBy($request)
        ->paginate((int)($request->per_page ?? 15));
        data_set($activities,'region',$region);

        return RegionCollection::make($activities)
        ->additional([
            'status' => true,
            'message' => ''
        ]);
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

        $region->fill($request->validated()+['updated_at'=>now()])->save();


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
