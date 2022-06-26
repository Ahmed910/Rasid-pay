<?php

use Illuminate\Support\Facades\Route;

Route::post('send-message', 'ContactController@sendMessage')->name('send_message');

Route::controller('Auth\LoginController')->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('send_reset_code', 'sendResetCode');
});

Route::controller('Auth\RegisterController')->group(function () {
    Route::post('register', 'register');
    Route::post('check_code', 'checkUserCode');
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
        // Currency
        Route::get('currencies', 'CurrencyController@index');
        // Wallet
        Route::apiResource('wallets', 'WalletController')->only('index', 'store');
        Route::post('send_wallet_otp', 'WalletController@sendWalletOtp');
        // Beneficiaries
        Route::get('get_receive_options','BeneficiaryController@getReceiveOptions');
        Route::apiResource('beneficiaries', 'BeneficiaryController');
        //money requests
        Route::post('money_requests', 'MoneyRequestController@store');
        //Transfer Purposes
        Route::get('transfer_purposes', 'TransferPurposeController@index');
        // Cards
        Route::apiResource('cards', 'CardController')->only('index','update', 'destroy');
        // Clients
        Route::apiResource('clients', 'ClientController')->only('index', 'show');
        // Packages
        Route::get('packages/promo_codes','PackageController@getPromoCodes');
        Route::apiResource('packages', 'PackageController')->only('index', 'show','update');
        // Transaction
        Route::get('download_transaction_file/{id}','TransactionController@generatePdfFile');
        Route::apiResource('transactions', 'TransactionController')->only('index', 'show');
        // Payment
        Route::apiResource('payments', 'PaymentController')->only('store', 'show');
        // Transfer
        Route::namespace('Transfers')->group(function () {
            // Wallet Transfers
            Route::post('wallet_transfers', 'WalletTransferController@store');
            Route::get('check_phone_wallets/{phone}', 'WalletTransferController@checkIfPhoneExists');
            // Local Transfers
            Route::post('local_transfers', 'LocalTransferController@store');
            // Global Transfers
            Route::post('global_transfers', 'GlobalTransferController@store');
            // All Transfers
            Route::get('transfers','TransferController@index');
        });

    // });
});

Route::get('slides', 'SlideController@index');
Route::get('banks', 'BankController@index');
