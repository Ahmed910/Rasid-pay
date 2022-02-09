<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboad\CurrencyRequest;
use App\Http\Resources\Dashboard\CurrencyResource;
use App\Models\Currency\Currency;
use Illuminate\Http\Request;


class CurrencyController extends Controller
{


    /**cc
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currencies = Currency::with('translations')->latest()->paginate((int)($request->perPage ?? 10));

        return CurrencyResource::collection($currencies)
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
    public function store(CurrencyRequest $request, Currency $currency)
    {
        $currency->fill($request->validated())->save();

        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_add")
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' => 'sucess'
            ]);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(CurrencyRequest $request, Currency $currency)
    {
        $currency->fill($request->validated())->save();

        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_update")
            ]);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();

        response()->json(['status' => true, 'message' => trans("dashboard.general.has_relationship_cannot_delete"), 'data' => null]);
    }
}
