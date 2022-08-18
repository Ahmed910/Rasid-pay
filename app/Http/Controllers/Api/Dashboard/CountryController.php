<?php

namespace App\Http\Controllers\Api\Dashboard;

use Illuminate\Http\Request;
use App\Models\Country\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ReasonRequest;
use App\Http\Requests\Dashboard\CountryRequest;
use App\Http\Resources\Api\Dashboard\Country\{CountryCodeCollection, CountryResource, CountryCollection};


class CountryController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
                'data' => countries_list("full",app()->getLocale()),
                'status' => true,
                'message' => '',
            ]);
    }

}
