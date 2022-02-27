<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\CountryRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\CountryResource;
use App\Models\ActivityLog;
use App\Models\Country\Country;
use Illuminate\Http\Request;


class CountryController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::latest()->paginate((int)($request->perPage ?? 10));

        return CountryResource::collection($countries)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }

    public function archive(Request $request)
    {
        $countries = Country::onlyTrashed()->latest()->paginate((int)($request->perPage ?? 10));

        return CountryResource::collection($countries)
            ->additional([
                'status' => true,
                'message' =>  ''
            ]);
    }

    public function create()
    {
        //
    }

    public function store(CountryRequest $request, Country $country)
    {
        $country->fill($request->validated())->save();

        return CountryResource::make($country)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_add'),
            ]);
    }



    public function show($id)
    {

        $country = Country::withTrashed()->findOrFail($id);

        $test = $country->translations->pluck('id');

        $Activity = ActivityLog::whereIn('auditable_id', $test)->where('auditable_type', 'App\Models\CountryTranslation')->get();

        return CountryResource::make($country)
            ->additional([
                'status' => true,
                'message' =>  '',
                'Activity' => $Activity
            ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(CountryRequest $request, Country $country)
    {
        $country->fill($request->validated())->save();

        return CountryResource::make($country)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_update'),
            ]);
    }

    //archive data
    public function destroy(ReasonRequest $request, Country $country)
    {
        if ($country->regions()->exists()) {
            return response()->json([
                'status' => false,
                'message' =>  trans('dashboard.general.has_relationship_cannot_delete'),
                'data' => null
            ], 422);
        }

        $country->delete();

        return CountryResource::make($country)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_archive'),
            ]);
    }

    //restore data from archive
    public function restore(ReasonRequest $request, $id)
    {
        $country = Country::onlyTrashed()->findOrFail($id);
        $country->restore();

        return CountryResource::make($country)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_restore'),
            ]);
    }

    //force delete data from archive
    public function forceDelete(ReasonRequest $request, $id)
    {
        $country = Country::onlyTrashed()->findOrFail($id);
        $country->forceDelete();

        return CountryResource::make($country)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_delete'),
            ]);
    }
}
