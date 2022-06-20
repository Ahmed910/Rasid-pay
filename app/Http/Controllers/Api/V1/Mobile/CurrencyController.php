<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Mobile\CurrencyResource;
use App\Models\Currency\Currency;

class CurrencyController extends Controller
{
    /**
     * @return CurrencyResource
     */
    public function index()
    {
        return CurrencyResource::collection(Currency::latest()->get())->additional(['status' => true, 'message' => '']);
    }

}
