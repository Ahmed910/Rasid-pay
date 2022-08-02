<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Mobile\CountryResource;
use App\Models\Country\Country;

class CountryController extends Controller
{
    public function index()
    {
        return CountryResource::collection(Country::orderByTranslation('name')->get()->unique('name'))->additional(['status' => true, 'message' => '']);
    }

}
