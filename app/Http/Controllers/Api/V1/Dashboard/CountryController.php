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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = Country::with(['translations' => fn ($q) => $q->where('locale', app()->getLocale())])->latest()->paginate((int)($request->perPage ?? 10));

        return CountryResource::collection($countries)
            ->additional([
                'message' => 'success',
                'status' => true
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request, Country $country)
    {
        $country->fill($request->validated())->save();

        return CountryResource::make($country)
            ->additional([
                'status' => true,
                'message' => 'sucess'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        return CountryResource::make($country)
            ->additional([
                'status' => true,
                'message' => ''
            ]);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, Country $country)
    {
        $country->fill($request->validated())->save();

        return CountryResource::make($country)
            ->additional([
                'status' => true,
                'message' => 'success'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        if ($country->regions()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'fail',
                'data' => null
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $country->delete();

        return CountryResource::make($country)
            ->additional([
                'status' => true,
                'message' => 'sucess'
            ]);
    }
}
