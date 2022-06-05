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
    Route::apiResource('profile', 'ProfileController')->only('index','store');
    Route::post('update_password', 'ProfileController@updatePassword');
    Route::get('get_citizen_wallet', 'WalletController@getCitizenWallet');
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
});
