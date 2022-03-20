<?php

use Illuminate\Support\Facades\Route;




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
        Route::middleware('auth')->prefix('dashboard')->group(function () {

            Route::get('password/code_check/{token}', 'Auth\ResetPasswordController@showCodeCheckForm')->name('check_sms_code_form');
            Route::post('password/phone_reset', 'Auth\ResetPasswordController@checkSmsCode')->name('check_sms_code');
            Route::get('password/phone_reset/{token}', 'Auth\ResetPasswordController@showPhoneResetForm')->name('get_phone_password_reset');
            Route::post('password/phone_reset/{token}', 'Auth\ResetPasswordController@resetUsingPhone')->name('reset_to_new');

            Route::get('activate/{confirmationCode}', 'Auth\LoginController@confirm')->name('confirmation_path');
            Route::post('setPassword', "Auth\LoginController@storePassword")->name('setPassword');
            Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
            Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('resetToNew');


            Route::middleware('auth')->prefix('dashboard')->group(function () {
                Route::get('/', "HomeController@index")->name("home.index");
                Route::post('logout', "Auth\LoginController@logout")->name("logout");
            });
            Route::resource('departments', "DepartmentController");
            Route::resource('departments2', "Department2Controller");

        });
    }
);
