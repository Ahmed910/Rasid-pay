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

    Route::controller('WalletController')->group(function () {
        Route::get('get_citizen_wallet', 'getCitizenWallet');
        Route::post('charge-wallet', 'chargeWallet');
    });
    

    Route::apiResource('card', 'CardController')->only('index','destroy');
    Route::controller('CardController')->name('card.')->prefix('card')->group(function () {
        Route::post('restore/{id}', 'restore')->name('restore');
        Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
    });

    Route::apiResource('profiles', 'ProfileController')->only('index','store');
    Route::apiResource('notifications', 'NotificationController')->only('index','show');
    Route::post('update_password', 'ProfileController@updatePassword');
    Route::post('MoneyRequests','MoneyRequestController@store');
    Route::post('activate_notifcation', 'ProfileController@activateNotifcation');
    Route::controller('TransactionController')->group(function () {
        Route::get('transactions', 'index');
        Route::get('transactions/{id}', 'show');

    });
});

Route::get('slides', 'SlideController@index');
Route::get('banks', 'BankController@index');


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
    Route::apiResource('profiles', 'ProfileController')->only('index', 'store');
    Route::post('update_password', 'ProfileController@updatePassword');
    // notifications
    Route::apiResource('notifications', 'NotificationController')->only('index', 'show');
    Route::post('activate_notification', 'ProfileController@activateNotification');
    // home
    Route::get('home', 'HomeController@index');
    // fetch wallet
    Route::get('fetch_wallet', 'HomeController@fetchWallet');
    // citizen wallet
    Route::get('get_citizen_wallet', 'WalletController@getCitizenWallet');

    //money requests
    Route::post('MoneyRequests', 'MoneyRequestController@store');

    // local transfers
    Route::post('local_transfer', 'LocalTransferController@store');

});

Route::get('slides', 'SlideController@index');
Route::get('banks', 'BankController@index');
Route::apiResource('clients', 'ClientController')->only('index', 'show');


