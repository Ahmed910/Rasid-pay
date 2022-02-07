<?php

namespace App\Http\Controllers\Api\Dashboard\v1;
namespace App\Http\Resources\Dashboard;

use App\Http\Controllers\Controller;
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
        //
        $currencies = Currency::with("children")->whereNull("parent_id")->paginate($request->page ?? 15);

        return CurrencyResource::collection($currencies);


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
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
        if(!$currency)
        {
            return $this->notFound();
        }
        return response()->json(['data'=> new CurrencyResource($currency), 'status' => 200 ,'message' => 'Currency Data'],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
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
        return response()->json(['data'=> new CurrencyResource($currency), 'status' => 200 ,'message' => 'Currency is updated'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
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
