<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\Api\Dashboard\CityController;
=======
use App\Http\Controllers\Api\Dashboard\v1\CountryController;
>>>>>>> e96536530f957d6635ce5b1f769782563f4000c4

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

<<<<<<< HEAD
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "dashboard"], function () {
    Route::apiResources([
        "cities" => CityController::class
    ]);
});
=======
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResources([
    'countries' => CountryController::class,
]);
>>>>>>> e96536530f957d6635ce5b1f769782563f4000c4
