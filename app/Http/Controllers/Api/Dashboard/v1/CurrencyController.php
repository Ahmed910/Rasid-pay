<?php

namespace App\Http\Controllers\Api\Dashboard\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\CurrencyResource;
use App\Models\Currency\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currencies = Currency::translatedIn('ar')->latest();
        return CurrencyResource::collection($currencies->paginate($request->perPage ?? 10))
            ->additional(['msg' => 'success', 'status' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $currency = Currency::create($request->all());
        return response()->json(['data' => new CurrencyResource($currency)]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        //
        if(!$currency)
        {
            return $this->notFound();
        }

        $currency->update($request->all());
        return response()->json(['data'=> new CurrencyResource($currency), 'status' => true,'message' => 'Currency is updated'],200);
    }

    public function destroy(Currency $currency)
    {
        //
        if(!$currency){

            return $this->notFound();
        }
       if($currency->delete()){

        return response()->json(['data'=> new CurrencyResource($currency), 'status' => 200 ,'message' => 'currency is deleted'],200);

       }else{

        return response()->errorRespone();
       }

}
}
