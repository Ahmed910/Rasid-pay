<?php

use Illuminate\Support\Facades\Artisan;
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

Route::post('login', "Auth\LoginController@login");
Route::post('send', "Auth\LoginController@sendCode");
Route::post('resend_code', "Auth\LoginController@resendCode");
Route::post('check_code', "Auth\LoginController@CheckResetCode");
Route::post('reset_password', "Auth\LoginController@resetPassword");
Route::post('otp_login', "Auth\LoginController@otpLogin");
Route::get('artisan_commend/{command}', function ($command) {
    ini_set('max_execution_time', 300);
    if ($command) {
        Artisan::call($command);
    }
});
Route::middleware('auth:sanctum')->group(function () {
    // Public Routes
    Route::post('logout', "Auth\LoginController@logout");
    Route::apiResource('notifications', 'NotificationController')->except('store');
    Route::apiResource('menus', 'MenuController');
    Route::get('permissions', 'GroupController@permissions');

    Route::controller('ProfileController')->name('profiles.')->prefix('profile')->group(function () {
        Route::get('show', 'show')->name('show');
        Route::post('update', 'update')->name('update');
        Route::post('change_password', 'changePassword')->name('change_password');
    });
    Route::post('settings/create-setting','SettingController@createSetting');
    Route::get('all-departments', 'DepartmentController@getAllDepartments');
    Route::get('all-groups', 'GroupController@getGroups');
    Route::get('all-jobs/{department}', 'RasidJobController@getVacantJobs');

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
            Route::get('create', 'create')->name('create');
            // Route::get('archive', 'archive')->name('archive');
            // Route::post('restore/{id}', 'restore')->name('restore');
            // Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
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
        Route::controller('BankController')->name('banks.')->prefix('banks')->group(function () {
            Route::get('archive', 'archive')->name('archive');
            Route::post('restore/{id}', 'restore')->name('restore');
            Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
        });

        Route::controller('ActivityController')->name('activity_logs.')->prefix('activity_logs')->group(function () {
            Route::get('departments', 'getDepartments')->name('departments');
            Route::get('employees', 'getEmployees')->name('employees');
            Route::get('main-programs','ActivityController@getMainPrograms')->name('main_programs');
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
            'banks' => 'BankController',
        ]);

        Route::apiResource('settings', 'SettingController')->only(['index', 'store']);
        Route::apiResource('activity_logs', 'ActivityController')->only(['index', 'show']);


        Route::resource('groups', 'GroupController')->except('create','edit','destroy');
    });
});
