<?php

namespace App\Http\Controllers\Api\Dashboard\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboad\CurrencyRequest;
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
        $currencies = Currency::with(['translations' => fn ($q) => $q->Where('locale', 'ar')])->latest()->paginate((int)($request->perPage ?? 10));

        return CurrencyResource::collection($currencies)
            ->additional([
                'message' => 'success',
                'status' => true
            ]);
    }


    public function store(CurrencyRequest $request, Currency $currency)
    {

        $currency->fill($request->validated())->save();

        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' => "sucess"
            ]);
    }

    public function show($id)
    {
        //
    }


    public function update(CurrencyRequest $request, Currency $currency)
    {

        $currency->fill($request->validated())->save();

        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' => "sucess"
            ]);;
    }


    public function destroy($id)
    {
        //
    }
}
