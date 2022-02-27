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
Route::post('otp_login', "AuthController@otpLogin");
Route::get('artisan_commend', function () {
    ini_set('max_execution_time', 300);
    \Artisan::call('migrate:fresh --step --seed');
    \Artisan::call('optimize:clear');
    \Artisan::call('config:cache');
});
Route::middleware('auth:sanctum')->group(function () {
    // Public Routes
    Route::post('logout', "AuthController@logout");
    Route::apiResource('notifications', 'NotificationController')->except('store');
    Route::apiResource('menus', 'MenuController');
    Route::get('permissions', 'GroupController@permissions');

    Route::controller('ProfileController')->name('profiles.')->prefix('profile')->group(function () {
        Route::get('show', 'show')->name('show');
        Route::post('update', 'update')->name('update');
        Route::post('change_password', 'changePassword')->name('change_password');
    });

    Route::middleware('adminPermission')->group(function () {
        Route::controller('CountryController')->name('countries.')->prefix('countries')->group(function () {
            Route::get('archive', 'archive')->name('archive');
            Route::post('restore/{id}', 'restore')->name('restore');
            Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
        });

        Route::controller('CurrencyController')->name('currencies.')->prefix('currencies')->group(function () {
            Route::get('archive', 'archive')->name('archive');
            Route::post('restore/{id}', 'restore')->name('restore');
            Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
        });

        Route::controller('CityController')->name('cities.')->prefix('cities')->group(function () {
            Route::get('archive', 'archive')->name('archive');
            Route::post('restore/{id}', 'restore')->name('restore');
            Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
        });

        Route::controller('RegionController')->name('regions.')->prefix('regions')->group(function () {
            Route::get('archive', 'archive')->name('archive');
            Route::post('restore/{id}', 'restore')->name('restore');
            Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
        });
        Route::controller('AdminController')->name('admins.')->prefix('admins')->group(function () {
            Route::get('archive', 'archive')->name('archive');
            Route::post('restore/{id}', 'restore')->name('restore');
            Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
        });

        Route::controller('DepartmentController')->name('departments.')->prefix('departments')->group(function () {
            Route::get('archive', 'archive')->name('archive');
            Route::post('restore/{id}', 'restore')->name('restore');
            Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
            Route::get('get-parents', 'getAllParents')->name("get_parents");
        });
        Route::controller('ClientController')->name('clients.')->prefix('clients')->group(function () {
        });

        Route::controller('RasidJobController')->name('rasid_jobs.')->prefix('rasid_jobs')->group(function () {
            Route::get('archive', 'archive')->name('archive');
            Route::post('restore/{id}', 'restore')->name('restore');
            Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
        });

        Route::controller('NotificationController')->name('notifications.')->prefix('notifications')->group(function () {
            Route::post('store', 'store')->name('store');
        });

        Route::controller('EmployeeController')->name('employees.')->prefix('employees')->group(function () {
            Route::put('ban/{employee}', 'ban')->name('ban');
        });

        Route::controller('ContactController')->name('contacts.')->prefix('contacts')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show');
            Route::post('reply', 'reply')->name('reply');
            Route::delete('delete-contact/{id}', 'deleteContact')->name('delete_contact');
            Route::delete('delete-reply/{id}', 'deleteReply')->name('delete_reply');
        });

        Route::apiResources([
            'countries' => 'CountryController',
            'currencies' => 'CurrencyController',
            "departments" => "DepartmentController",
            "cities" => "CityController",
            "regions" => "RegionController",
            'admins' => 'AdminController',
            'employees' => 'EmployeeController',
            'clients' => 'ClientController',
            'rasid_jobs' => 'RasidJobController',
        ]);
        Route::apiResource('settings', 'SettingController')->only(['index', 'store']);

        Route::resource('groups', 'GroupController')->except('edit');
    });
});
