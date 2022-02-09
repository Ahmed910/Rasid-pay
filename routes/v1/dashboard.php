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



Route::controller('CountryController')->name('countries.')->prefix('countries')->group(function () {
    Route::get('archive', 'archive')->name('archive');
    Route::post('restore/{id}', 'restore')->name('restore');
    Route::delete('delete/{id}', 'delete')->name('delete');
});

Route::resources([
    'countries' => 'CountryController',
    'currencies' => 'CurrencyController',
    "departments" => "DepartmentController",
    "cities" => "CityController",
    "regions" => "RegionController",
    'roles' => 'RoleController',
]);
