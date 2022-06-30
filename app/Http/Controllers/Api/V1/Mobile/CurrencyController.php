<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Mobile\CurrencyResource;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $currencies = Currency::orderBy('currency_code')->get();
        if ($currencies->first()->last_updated_at->diffInDays(Carbon::now()) == 0) {
            return CurrencyResource::collection($currencies)->additional(['status' => true, 'message' => '']);
        }
        // Fetching JSON
        $req_url = 'https://v6.exchangerate-api.com/v6/fb6f699c2c0e6b19d30429dc/latest/SAR';
        $response_json = file_get_contents($req_url);
        // Continuing if we got a result
        if (false !== $response_json) {
            // Try/catch for json_decode operation
            try {
                // Decoding
                $response_object = json_decode($response_json);
                foreach ($response_object->conversion_rates as $key => $value) {
                    Currency::updateOrCreate(['currency_code' => $key,],
                        [
                            'currency_value' => $value,
                            'last_updated_at' => Carbon::parse($response_object->time_last_update_unix)
                        ]);
                }
                // YOUR APPLICATION CODE HERE, e.g.
                return CurrencyResource::collection($currencies)->additional(['status' => true, 'message' => '']);
            } catch (\Exception $e) {
                // Handle JSON parse error...
                throw new \Exception('Error parsing JSON');
            }
        }
    }

}
