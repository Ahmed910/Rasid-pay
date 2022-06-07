<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\Currency\{CurrencyResource, CurrencyCollection};
use App\Http\Requests\V1\Dashboard\CurrencyRequest;
use App\Models\Currency\Currency;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Dashboard\ReasonRequest;


class CurrencyController extends Controller
{

    public function index(Request $request)
    {
        $currencies = Currency::latest()->paginate((int)($request->per_page ?? config("globals.per_page")));

        return CurrencyResource::collection($currencies)
            ->additional([
                'message' => '',
                'status' => true
            ]);
    }

    public function archive(Request $request)
    {
        $currencies = Currency::onlyTrashed()->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));

        return CurrencyResource::collection($currencies)
            ->additional([
                'message' => '',
                'status' => true
            ]);
    }

    public function create()
    {
        //
    }

    public function store(CurrencyRequest $request, Currency $currency)
    {
        $currency->fill($request->validated() + ['added_by_id' => auth()->id()])->save();

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
    public function show(Request $request ,$id)
    {
        $currency = Currency::withTrashed()->with('translations')->findOrFail($id);
        $activities  = $currency->activity()
        ->sortBy($request)
        ->paginate((int)($request->per_page ??  config("globals.per_page")));

        return CurrencyCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(CurrencyRequest $request, Currency $currency)
    {
        $currency->fill($request->validated()+['updated_at'=>now()])->save();
        $currency->updated_at=now();
        $currency->save();


        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_update")
            ]);;
    }

    public function destroy(ReasonRequest $request, Currency $currency)
    {
        if ($currency->countries()->exists()) {
            return response()->json([
                'status' => false,
                'message' =>  trans('dashboard.general.has_relationship_cannot_delete'),
                'data' => null
            ], 422);
        }
        $currency->delete();

        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_archive'),
            ]);
    }


    public function restore(ReasonRequest $request, $id)
    {

        $currency = Currency::onlyTrashed()->findOrFail($id);

        $currency->restore();

        return CurrencyResource::make($currency)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.restore')

            ]);
    }


    public function forceDelete(ReasonRequest $request, $id)
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
