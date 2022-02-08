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
        $currencies = Currency::withTranslation()->latest()->paginate((int)($request->perPage ?? 10));
        return CurrencyResource::collection($currencies)
            ->additional(['message' => 'success', 'status' => true]);
    }


    public function store(CurrencyRequest $request){

        $validated = $request->validated();

        dd($validated);

    }

    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
