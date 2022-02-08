<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\v1\CountryController;
use App\Http\Controllers\Api\Dashboard\v1\CityController;
=======
>>>>>>> 690101040a80ecbdacf8d8ce90f53cd2158ca683

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResources([
<<<<<<< HEAD
    'countries' => CountryController::class,
    'cities' => CityController::class,

=======
    'countries' => 'CountryController',
    'currencies' => 'CurrencyController',
    "departments" => "DepartmentController"
>>>>>>> 690101040a80ecbdacf8d8ce90f53cd2158ca683
]);

