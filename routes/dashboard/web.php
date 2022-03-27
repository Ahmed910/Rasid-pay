<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'as' => 'dashboard.',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        // Dashboard Login
        Route::get('dashboard/login', "Auth\LoginController@showLoginForm")->name("login");
        Route::post('dashboard/login', "Auth\LoginController@login")->name("post_login");
        Route::get('dashboard/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('reset');
        Route::post('dashboard/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('post_reset');
        Route::view('dashboard/password/view_email', 'dashboard.auth.verify_code1');

        Route::get('password/code_check/{token}', 'Auth\ResetPasswordController@showCodeCheckForm')->name('check_sms_code_form');
        Route::post('password/phone_reset', 'Auth\ResetPasswordController@checkSmsCode')->name('check_sms_code');
        Route::get('password/phone_reset/{token}', 'Auth\ResetPasswordController@showPhoneResetForm')->name('get_phone_password_reset');
        Route::post('password/phone_reset/{token}', 'Auth\ResetPasswordController@resetUsingPhone')->name('reset_to_new');

        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('resetToNew');

        Route::middleware('auth')->prefix('dashboard')->group(function () {
            Route::get('/', "HomeController@index")->name("home.index");
            Route::post('logout', "Auth\LoginController@logout")->name("session.logout");
            Route::resource('activity_log', 'ActivityLogController')->only('index', 'show');

            Route::controller('JobController')->name('job.')->prefix('job')->group(function () {
                Route::get('archive', 'archive')->name('archive');
                Route::post('restore/{id}', 'restore')->name('restore');
                Route::delete('forceDelete/{id}', 'forceDelete')->name('forceDelete');
            });

            Route::controller('DepartmentController')->name('department.')->prefix('department')->group(function () {
                Route::get('archive', 'archive')->name('archive');
                Route::post('restore/{id}', 'restore')->name('restore');
                Route::delete('forceDelete/{id}', 'forceDelete')->name('forceDelete');
            });


            Route::resources([
                'job' => 'JobController',
                'department' => 'DepartmentController',
                'group' => 'GroupController',
                'client' => 'ClientController',
                'employee' => 'EmployeeController',
                'admin' => 'AdminController',
            ]);
        });
    }
);
