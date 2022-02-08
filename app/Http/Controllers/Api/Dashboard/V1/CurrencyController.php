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
    /**cc
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $currencies = Currency::withTranslation()->latest()->paginate((int)($request->perPage ?? 10));
        return CurrencyResource::collection($currencies)
            ->additional(['message' => 'success', 'status' => true]);
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
        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' => "Currency data"
            ]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        //
        $currency->delete();

    response()->ajax(['status' => true , 'message' => 'currency has deleted' , 'data' => null]);


    }
}
