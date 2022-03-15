<?php

use Illuminate\Support\Facades\Route;

Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
    'as' => 'dashboard.',
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function(){
    // Dashboard Login
    Route::get('dashboard/login', "Auth\LoginController@showLoginForm")->name("login");
	Route::post('dashboard/login', "Auth\LoginController@login")->name("post_login");
    Route::middleware('auth')->prefix('dashboard')->group(function () {
        Route::get('/', "HomeController@index")->name("home.index");

    });
    Route::resource('departments',"DepartmentController");
});
