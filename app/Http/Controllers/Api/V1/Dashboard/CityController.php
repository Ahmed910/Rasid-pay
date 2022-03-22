<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\City\{CityResource, CityCollection};
use App\Http\Requests\V1\Dashboard\CityRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Models\City\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function index(Request $request)
    {
        $city = City::latest()->paginate((int)($request->per_page ?? config("globals.per_page")));

        return CityResource::collection($city)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function archive(Request $request)
    {
        $cities = City::onlyTrashed()->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));

        return CityResource::collection($cities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function store(CityRequest $request, City $city)
    {
        $city->fill($request->validated() + ['added_by_id' => auth()->id()])->save();

        return CityResource::make($city)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_add')
            ]);
    }


    public function show(Request $request ,$id)
    {
        $city = City::withTrashed()->with('translations')->findOrFail($id);
        $activities  = $city->activity()
        ->sortBy($request)
        ->paginate((int)($request->per_page ?? 15));
        data_set($activities, 'city', $city);

        return CityCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }



    public function update(CityRequest $request, City $city)
    {
        $city->fill($request->validated() + ['updated_at' => now()])->save();


        return CityResource::make($city)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_update')
            ]);
    }


    //soft delete (archive)
    public function destroy(ReasonRequest $request, City $city)
    {

        $city->delete();

        return CityResource::make($city)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_archive')
            ]);
    }


    public function restore(ReasonRequest $request, $id)
    {
        $city = City::onlyTrashed()->findOrFail($id);
        $city->restore();

        return CityResource::make($city)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.restore')
            ]);
    }

    public function forceDelete(ReasonRequest $request, $id)
    {

        $city = City::onlyTrashed()->findOrFail($id);
        $city->forceDelete();

        return CityResource::make($city)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_delete')
            ]);
    }
}
