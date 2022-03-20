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

		Route::get('password/code_check/{token}', 'Auth\ResetPasswordController@showCodeCheckForm')->name('check_sms_code_form');
		Route::post('password/phone_reset', 'Auth\ResetPasswordController@checkSmsCode')->name('check_sms_code');
		Route::get('password/phone_reset/{token}', 'Auth\ResetPasswordController@showResetPhoneForm')->name('passwords.reset.phone');
		Route::post('password/phone_reset/{token}', 'Auth\ResetPasswordController@resetUsingPhone')->name('reset_to_new');

		Route::get('password/email_reset/{token}', 'Auth\ResetPasswordController@showResetEmailForm')->name('passwords.reset.email');
		Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('passwords.reset.new_password');
		Route::get('activate/{confirmationCode}', 'Auth\LoginController@confirm')->name('confirmation_path');
		Route::post('setPassword', "Auth\LoginController@storePassword")->name('setPassword');

    Route::middleware('auth')->prefix('dashboard')->group(function () {
        Route::get('/', "HomeController@index")->name("home.index");

    });
    Route::resource('departments',"DepartmentController");
    Route::resource('jobs',"Job2Controller");
        Route::middleware('auth')->prefix('dashboard')->group(function () {
            Route::get('/', "HomeController@index")->name("home.index");
            Route::post('logout', "Auth\LoginController@logout")->name("logout");
			Route::resource('departments', "DepartmentController");
        });
});
