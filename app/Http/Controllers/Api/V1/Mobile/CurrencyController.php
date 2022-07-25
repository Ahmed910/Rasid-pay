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
        $currencies = Currency::orderBy('currency_code')->get();
        if ($currencies->first() && $currencies->first()->last_updated_at->diffInDays(Carbon::now()) == 0) {
            return CurrencyResource::collection($currencies)->additional(['status' => true, 'message' => '']);
        }
        $currencies = calcCurrency('SAR');
        foreach ($currencies->rates as $key => $value) {
            Currency::updateOrCreate(['currency_code' => $key,],
                [
                    'currency_value' => $value,
                    'last_updated_at' => $currencies->date
                ]);
        }
        return CurrencyResource::collection($currencies)->additional(['status' => true, 'message' => '']);
    }


    public function convertCurrency(CurrencyRequest $request)
    {
        $base = $request->base;
        $to = $request->to;
        $amount = $request->amount ?: 1;
        $data = [];
        $currencies = calcCurrency($base, $to, $amount);
        foreach ($currencies->rates as $key => $value) {
            if ($key == $to) {
                $data['conversion_value'] = $value;
                break;
            }
        }
        return response()->json([
            'date' => $data,
            'status' => true,
            'message' => '',
        ]);

    }

}
