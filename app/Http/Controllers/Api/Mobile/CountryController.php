<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Mobile\CountryResource;
use App\Models\Country\Country;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::whereHas('translations',function ($q) {
            $q->whereNotNull('name');
        })->orderByTranslation('name')->get();
        return CountryResource::collection($countries)->additional(['status' => true, 'message' => '']);
    }

}
