<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\CurrencyRequest;
use App\Http\Resources\Api\V1\Mobile\CurrencyResource;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $currencies = Currency::whereHas('country',function ($q) {
            $q->whereHas('translations',function ($q) {
                $q->whereNotNull('country_translations.name');
            });
        })->orderBy('currency_code')->get();
        if (!$currencies->first()?->last_updated_at?->isToday()){
            $sarCurrencies = calcCurrency('SAR');
            foreach ($sarCurrencies->rates as $key => $value) {
                Currency::updateOrCreate(['currency_code' => $key],
                [
                    'currency_value' => $value,
                    'last_updated_at' => $sarCurrencies->date
                ]);
            }
        }
        return CurrencyResource::collection($currencies)->additional(['status' => true, 'message' => '']);
    }


    public function convertCurrency(CurrencyRequest $request)
    {
        $base = $request->base;
        $to = $request->to;

        $currencies = (array)calcCurrency($base)->rates;
        $keys = array_keys($currencies);

        $data['conversion_value'] = binarySearchForAssocArray($to,$currencies,$keys);
        return response()->json([
            'data' => $data,
            'status' => true,
            'message' => '',
        ]);

    }

}
