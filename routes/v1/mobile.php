<?php

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

Route::post('send-message', 'ContactController@sendMessage')->name('send_message');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::apiResource('profiles', 'ProfileController')->only('index','store');
    Route::apiResource('notifications', 'NotificationController')->only('index','show');
    Route::post('update_password', 'ProfileController@updatePassword');
    Route::get('get_citizen_wallet', 'WalletController@getCitizenWallet');
    Route::post('MoneyRequests','MoneyRequestController@store');
    Route::post('activate_notifcation', 'ProfileController@activateNotifcation');

});

Route::get('slides','SlideController@index');
Route::get('banks','BankController@index');


Route::controller('Auth\LoginController')->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('send_reset_code', 'sendResetCode');
});

Route::controller('Auth\RegisterController')->group(function () {
    Route::post('register', 'register');
    Route::post('check-verification-code', 'checkVerificationCode');
    Route::post('complete-register', 'completeRegister');
});

Route::controller('Auth\ResetController')->group(function () {
    Route::post('check-identity-number', 'checkIdentityNumber');
    Route::post('reset-password', 'updatePassword');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::apiResource('profile', 'ProfileController')->only('index', 'store');
    Route::post('update_password', 'ProfileController@updatePassword');
    Route::post('activate_notification', 'ProfileController@activateNotification');

    // home
    Route::get('home', 'HomeController@index');

    // citizen wallet
    Route::get('get_citizen_wallet', 'WalletController@getCitizenWallet');

});

Route::get('slides', 'SlideController@index');
Route::get('banks', 'BankController@index');

