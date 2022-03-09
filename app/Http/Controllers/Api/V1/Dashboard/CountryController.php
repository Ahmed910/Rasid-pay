<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use Illuminate\Http\Request;
use App\Models\Country\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Requests\V1\Dashboard\CountryRequest;
use App\Http\Resources\Dashboard\Country\{CountryResource, CountryCollection};



class CountryController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::latest()->paginate((int)($request->per_page ?? config("globals.per_page")));

        return CountryResource::collection($countries)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }

    public function archive(Request $request)
    {
        $countries = Country::onlyTrashed()->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));

        return CountryResource::collection($countries)
            ->additional([
                'status' => true,
                'message' =>  ''
            ]);
    }



    public function store(CountryRequest $request, Country $country)
    {


        $country->fill($request->validated() + ['added_by_id' => auth()->id()])->save();

        return CountryResource::make($country)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_add'),
            ]);
    }



    public function show(Request $request, $id)
    {
        $country = Country::withTrashed()->with('translations')->findOrFail($id);
        $activities  = $country->activity()->paginate((int)($request->per_page ?? 15));
        data_set($activities, 'country', $country);


        return CountryCollection::make($activities)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }


    public function update(CountryRequest $request, Country $country)
    {
        $country->fill($request->validated() + ['updated_at' => now()])->save();


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
