<?php

use App\Http\Controllers\Api\Dashboard\v1\CityController;
//use App\Http\Controllers\Api\Dashboard\v1\CountryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
<<<<<<< HEAD

//Route::group(["prefix" => "dashboard"], function () {
//    Route::apiResources([
//        "cities" => CityController::class
//    ]);
//});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//
//Route::apiResources([
//    'countries' => CountryController::class,
//]);
=======
>>>>>>> 690101040a80ecbdacf8d8ce90f53cd2158ca683
