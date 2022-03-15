<?php

use Illuminate\Support\Facades\Route;

Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
    'as' => 'dashboard.',
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function(){
    // Dashboard Login
    Route::get('login', "Auth\LoginController@showLoginForm")->name("login");
	Route::post('login', "Auth\LoginController@login")->name("post_login");
    Route::middleware('auth')->group(function () {
        Route::get('/', "HomeController@index")->name("home.index");

    });
});
