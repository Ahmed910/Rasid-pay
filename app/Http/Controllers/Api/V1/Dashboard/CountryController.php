<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use Illuminate\Http\Request;
use App\Models\Country\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Requests\V1\Dashboard\CountryRequest;
use App\Http\Resources\Dashboard\Country\{CountryCodeCollection, CountryResource, CountryCollection};


class CountryController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
                'data' => countries_list("full"),
                'status' => true,
                'message' => '',
            ]);
    }

}
