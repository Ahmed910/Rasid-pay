<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\CurrencyRequest;
use App\Http\Resources\Dashboard\CurrencyResource;
use App\Models\Currency\Currency;
use Illuminate\Http\Request;


class CurrencyController extends Controller
{

    public function index(Request $request)
    {
        $currencies = Currency::latest()->paginate((int)($request->perPage ?? 10));

        return CurrencyResource::collection($currencies)
            ->additional([
                'message' => 'success',
                'status' => true
            ]);
    }

    public function create()
    {
        //
    }

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
    public function show($id)

    {
        $currency = Currency::withTrashed()->findOrFail($id);

        return CurrencyResource::make($currency->load('translations'))
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
            ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(CurrencyRequest $request, Currency $currency)
    {
        $currency->fill($request->validated())->save();

        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_update")
            ]);;
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();

        response()->json([
            'status' => true,
            'message' => trans("dashboard.general.has_relationship_cannot_delete"), 'data' => null
        ]);
    }


    public function restore($id)
    {

        $currency = Currency::findOrFail($id)->restore();

        // $currency->restore();

        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.restore')

            ]);
    }


    public function forceDelete(Currency $currency)
    {


        $currency->forceDelete();

        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_delete')
            ]);
    }
}
