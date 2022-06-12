<?php

use Illuminate\Support\Facades\Route;

Route::post('send-message', 'ContactController@sendMessage')->name('send_message');

Route::controller('Auth\LoginController')->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('send_reset_code', 'sendResetCode');
});

Route::controller('Auth\RegisterController')->group(function () {
    Route::post('register', 'register');
    Route::post('check_verification_code', 'checkVerificationCode');
    Route::post('complete_register', 'completeRegister');
});

Route::controller('Auth\ResetController')->group(function () {
    Route::post('check_identity_number', 'checkIdentityNumber');
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
        Route::post('activate_notification', 'ProfileController@activateNotification');
        // home
        Route::get('home', 'HomeController@index');
        // fetch wallet
        Route::get('fetch_wallet', 'HomeController@fetchWallet');
        // citizen wallet
        Route::get('get_citizen_wallet', 'WalletController@getCitizenWallet');
        //money requests
        Route::post('money_requests', 'MoneyRequestController@store');

        // local transfers
        Route::controller('LocalTransferController')->name('local_transfer.')->prefix('local_transfer')->group(function () {
            Route::post('/', 'store');
        });

        Route::controller('WalletController')->group(function () {
            Route::get('get_citizen_wallet', 'getCitizenWallet');
            Route::post('wallet_charges', 'chargeWallet');
            // wallet bin
            Route::post('wallet_bin','checkForWalletBin');
        });

        Route::controller('PackageController')->group(function () {
            Route::get('get_packages', 'getPackages');
        });

        Route::apiResource('card', 'CardController')->only('index', 'destroy');
        Route::controller('CardController')->name('card.')->prefix('card')->group(function () {
            Route::post('restore/{id}', 'restore')->name('restore');
            Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
        });

        Route::controller('TransactionController')->group(function () {
            Route::get('transactions', 'index');
            Route::get('transactions/{id}', 'show');
        });
    // });
    Route::controller('PaymentController')->group(function () {
        Route::post('payment', 'store');
    //            Route::get('payment/{id}', 'show');
    });
    Route::apiResource('beneficiaries','BeneficiaryController');

    Route::apiResource('wallet_transfers', 'Transfers\WalletTransferController');
});

Route::get('slides', 'SlideController@index');
Route::get('banks', 'BankController@index');
Route::apiResource('clients', 'ClientController')->only('index', 'show');
