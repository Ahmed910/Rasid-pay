<?php

use Illuminate\Support\Facades\Route;

Route::post('send-message', 'ContactController@sendMessage')->name('send_message');

Route::controller('Auth\LoginController')->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('send_reset_code', 'sendResetCode');
});

Route::controller('Auth\RegisterController')->group(function () {
    Route::post('register', 'register');
    Route::post('verify_phone_code', 'verifyPhoneCode');
    Route::post('complete_register', 'completeRegister');
});

Route::controller('Auth\ResetController')->group(function () {
    // Route::post('check_identity_number', 'checkIdentityNumber');
    Route::post('reset_password', 'updatePassword');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('set_wallet_bin', 'ProfileController@setWalletBin');
    // Route::middleware('check_wallet_bin')->group(function () {

        Route::post('logout', 'Auth\LoginController@logout');
        Route::apiResource('profiles', 'ProfileController')->only('index', 'store');
        Route::post('update_password', 'ProfileController@updatePassword');
        // notifications
        Route::apiResource('notifications', 'NotificationController')->only('index', 'show');
        Route::post('active_notifications', 'ProfileController@activateNotification');
        // home
        Route::get('home', 'HomeController@index');
        // Wallet
        Route::apiResource('wallets', 'WalletController')->only('index', 'store');
        Route::post('need_to_transfers', 'WalletController@sendWalletOtp');
        // Beneficiaries
        Route::apiResource('beneficiaries', 'BeneficiaryController');
        //money requests
        Route::post('money_requests', 'MoneyRequestController@store');
        // Cards
        Route::apiResource('cards', 'CardController')->only('index', 'destroy');
        // Clients
        Route::apiResource('clients', 'ClientController')->only('index', 'show');
        // Packages
        Route::apiResource('packages', 'PackageController')->only('index', 'show');
        // Transfer
        Route::namespace('Transfers')->group(function () {
            // Wallet Transfers
            Route::apiResource('wallet_transfers', 'WalletTransferController');
            Route::get('check_phone_wallets/{phone}', 'WalletTransferController@checkIfPhoneExists');
            // Local Transfers
            Route::post('local_transfers', 'LocalTransferController@store');
        });

    Route::controller('TransactionController')->group(function () {
        Route::get('transactions', 'index');
        Route::get('transactions/{id}', 'show');
    });
    // });
    Route::controller('PaymentController')->group(function () {
        Route::post('payment', 'store');
        Route::get('payment/{id}', 'show');
    });


});

Route::get('slides', 'SlideController@index');
Route::get('banks', 'BankController@index');
