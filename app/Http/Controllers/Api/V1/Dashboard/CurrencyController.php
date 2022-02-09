<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboad\CurrencyRequest;
use App\Http\Resources\Dashboard\CurrencyResource;
use App\Models\Currency\Currency;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


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

    public function archive(Request $request)
    {
        $currencies = Currency::onlyTrashed()->latest()->paginate((int)($request->perPage ?? 10));

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
        if ($currency->countries()->exists()) {
            return response()->json([
                'status' => false,
                'message' =>  trans('dashboard.general.has_relationship_cannot_delete'),
                'data' => null
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $currency->delete();

        return CurrencyResource::make($currency)
        ->additional([
            'status' => true,
            'message' =>  trans('dashboard.general.success_archive'),
        ]);
    }


    public function restore($id)
    {

        $currency = Currency::onlyTrashed()->findOrFail($id);

        $currency->restore();

        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.restore')

            ]);
    }


    public function forceDelete($id)
    {
        $currency = Currency::onlyTrashed()->findOrFail($id);
        $currency->forceDelete();

        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_delete'),
            ]);
    }
}
