<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResources([
    'countries' => 'CountryController',
    'currencies' => 'CurrencyController',
    "departments" => "DepartmentController",
    "cities" => "CityController",
    "regions" => "RegionController"
]);

Route::resources([
    'roles' => 'RoleController',
]);

Route::group(['prefix' => 'cities', 'as' => 'cities.'], function(){

    Route::post('/restore/{city}', 'CityController@restore')->name('restore');
    Route::delete('/force-delete/{city}', 'CityController@forceDelete')->name('force_delete');

});  // End of the /cities Route Group


