<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileCurrencyRequest;
use App\Http\Resources\Api\Mobile\CurrencyResource;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $currency_today = Currency::first();
        if (!$currency_today || !$currency_today->last_updated_at?->isToday()){
            $sarCurrencies = calcCurrency('SAR');
            foreach ($sarCurrencies->rates as $key => $value) {
                Currency::updateOrCreate(['currency_code' => $key],
                [
                    'currency_value' => $value,
                    'last_updated_at' => $sarCurrencies->date
                ]);
            }
        }
        $currencies = Currency::whereHas('country',function ($q) {
            $q->whereHas('translations',function ($q) {
                $q->whereNotNull('country_translations.name');
            });
        })->orderBy('currency_code')->get();
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