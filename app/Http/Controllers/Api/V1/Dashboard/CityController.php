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
        $city = City::paginate($request->page ?? 15);

        return CityResource::collection($city)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function create()
    {
        //
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

    public function edit($id)
    {
        //
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


    public function destroy(City $city)
    {

        $city->delete();

        return CityResource::make($city)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_delete')
            ]);
    }
}
