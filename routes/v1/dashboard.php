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

Route::post('login', "AuthController@login");
Route::post('send', "AuthController@sendCode");
Route::post('reset_password', "AuthController@resetPassword");
Route::post('logout', "AuthController@logout");

Route::middleware('auth:sanctum', 'adminPermission')->group(function () {

    Route::controller('CountryController')->name('countries.')->prefix('countries')->group(function () {
        Route::get('archive', 'archive')->name('archive');
        Route::post('restore/{id}', 'restore')->name('restore');
        Route::delete('forceDelete/{id}', 'forceDelete')->name('forceDelete');
    });

    Route::controller('CurrencyController')->prefix('currencies')->group(function () {
        Route::get('archive', 'archive')->name('archive');
        Route::post('restore/{id}', 'restore')->name('restore');
        Route::delete('forceDelete/{id}', 'forceDelete')->name('forceDelete');
    });

    Route::controller('CityController')->name('cities.')->prefix('cities')->group(function () {
        Route::get('archive', 'archive')->name('archive');
        Route::post('restore/{id}', 'restore')->name('restore');
        Route::delete('forceDelete/{id}', 'forceDelete')->name('forceDelete');
    });

    Route::controller('RegionController')->name('regions.')->prefix('regions')->group(function () {
        Route::get('archive', 'archive')->name('archive');
        Route::post('restore/{id}', 'restore')->name('restore');
        Route::delete('forceDelete/{id}', 'forceDelete')->name('forceDelete');
    });
    Route::controller('AdminController')->name('admins.')->prefix('admins')->group(function () {
        Route::get('archive', 'archive')->name('archive');
        Route::post('restore/{id}', 'restore')->name('restore');
        Route::delete('forceDelete/{id}', 'forceDelete')->name('forceDelete');
    });

    Route::controller('DepartmentController')->name('departments.')->prefix('departments')->group(function () {
        Route::delete('forceDelete/{department}', 'forceDestroy')->name('forceDelete');
    });
    Route::controller('CustomerController')->name('customers.')->prefix('customers')->group(function () {
        Route::delete('forceDelete/{id}', 'forceDestroy')->name('forceDelete');
        Route::get('archive/get', 'archive')->name('archive');
        Route::post('restore/{id}', 'restore')->name('restore');
    });

    Route::controller('RasidJobController')->name('rasidjobs.')->prefix('rasid_jobs')->group(function () {
        Route::get('archive', 'archive')->name('archive');
        Route::post('restore/{id}', 'restore')->name('restore');
        Route::delete('forceDelete/{id}', 'forceDelete')->name('forceDelete');
    });

    Route::controller('ProfileController')->name('profile.')->prefix('profile')->group(function () {
        Route::get('show', 'show')->name('show');
        Route::post('update', 'update')->name('update');
        Route::post('change-password', 'changePassword')->name('changePassword');
    });

    Route::controller('NotificationController')->name('notifications.')->prefix('notifications')->group(function () {
        Route::post('updateNotification', 'updateNotification')->name('updateNotification');
    });

    Route::resources([
        'countries' => 'CountryController',
        'currencies' => 'CurrencyController',
        "departments" => "DepartmentController",
        "cities" => "CityController",
        "regions" => "RegionController",
        'roles' => 'RoleController',
        'admins' => 'AdminController',
        'customers' => 'CustomerController',
        'rasid_jobs' => 'RasidJobController',
        'notifications' => 'NotificationController',
        'profiles' => 'ProfileController',
        'settings' => 'SettingController',
    ]);
});
