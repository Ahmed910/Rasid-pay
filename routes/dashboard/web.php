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

            Route::get('/home', "Auth\LoginController@showLoginForm")->name("home.index");
            Route::get('/', "Auth\LoginController@showLoginForm")->name("home.index");
            Route::get('dashboard/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('reset');
            Route::post('dashboard/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('post_reset');

            Route::get('activate/{confirmationCode}', 'Auth\LoginController@confirm')->name('confirmation_path');
            Route::post('setPassword', "Auth\LoginController@storePassword")->name('setPassword');
            Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
            Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('resetToNew');
            Route::get('/', "HomeController@index")->name("home.index");
            Route::resource('departments', "DepartmentController");
        });
    }
);
