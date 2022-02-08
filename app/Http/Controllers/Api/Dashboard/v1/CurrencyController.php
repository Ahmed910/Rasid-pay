<?php

namespace App\Http\Controllers\Api\Dashboard\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\CurrencyResource;
use App\Models\Currency\Currency;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;


class CurrencyController extends Controller
{

    use SoftDeletes;
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
    public function show(Currency $currency)
    {
        //
        return response()->json(['data'=> new CurrencyResource($currency),'status'=>true,'message'=>'Currency data'],200);



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

    }

    public function destroy(Currency $currency)
    {
        //
        $currency->delete();
        return response()->ajax(['status' => true, 'message' => "data deleted", 'data' => null]);



}
public function restore(Currency $currency){

if($currency->softDeletes()){


}

}
}
