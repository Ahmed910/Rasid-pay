<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboad\CountryRequest;
use App\Http\Resources\Dashboard\CountryResource;
use App\Models\Country\Country;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CountryController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::with('currency')->latest()->paginate((int)($request->perPage ?? 10));

        return CountryResource::collection($countries)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_add'),
            ]);
    }

    public function archive(Request $request)
    {
        $countries = Country::onlyTrashed()->latest()->paginate((int)($request->perPage ?? 10));

        return CountryResource::collection($countries)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_add'),
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



    public function show(Country $country)
    {
        return CountryResource::make($country)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);;
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
    public function destroy(Country $country)
    {
        if ($country->regions()->exists()) {
            return response()->json([
                'status' => false,
                'message' =>  trans('dashboard.general.has_relationship_cannot_delete'),
                'data' => null
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $country->delete();

        return CountryResource::make($country)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_archive'),
            ]);
    }

    //restore data from archive
    public function restore($id)
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
    public function delete($id)
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
