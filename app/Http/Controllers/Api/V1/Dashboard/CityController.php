<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboad\CityRequest;
use App\Http\Resources\Dashboard\CityResource;
use App\Models\City\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function index(Request $request)
    {
        $city = City::latest()->paginate($request->page ?? 15);

        return CityResource::collection($city)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function archive(Request $request)
    {
        $cities = City::onlyTrashed()->latest()->paginate((int)($request->perPage ?? 10));

        return CityResource::collection($cities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function store(CityRequest $request, City $city)
    {
        $city->fill($request->validated())->save();

        return CityResource::make($city)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_add')
            ]);
    }


    public function show(City $city)
    {
        return CityResource::make($city)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }



    public function update(CityRequest $request, City $city)
    {
        $city->fill($request->validated())->save();

        return CityResource::make($city)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_update')
            ]);
    }


    //soft delete (archive)
    public function destroy(City $city)
    {

        $city->delete();

        return CityResource::make($city)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_archive')
            ]);
    }


    public function restore($id)
    {
        $city = City::onlyTrashed()->findOrFail($id);
        $city->restore();

        return CityResource::make($city)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.restore')
            ]);
    }

    public function delete($id)
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
