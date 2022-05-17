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
        Route::view('dashboard/password/view_email', 'dashboard.auth.verify_code1');

        Route::get('password/code_check/{token}', 'Auth\ResetPasswordController@showCodeCheckForm')->name('check_sms_code_form');
        Route::post('password/phone_reset', 'Auth\ResetPasswordController@checkSmsCode')->name('check_sms_code');
        Route::get('password/phone_reset/{token}', 'Auth\ResetPasswordController@showResetPhoneForm')->name('get_phone_password_reset');
        Route::post('password/phone_reset/{token}', 'Auth\ResetPasswordController@resetUsingPhone')->name('reset_to_new');

        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('passwords.reset.email');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('resetToNew');
        Route::get('password/resend_code/{token}', 'Auth\ForgotPasswordController@resendCode')->name('resend_code');

        Route::middleware('auth')->prefix('dashboard')->group(function () {
            Route::get('/', "HomeController@index")->name("home.index");
            Route::get('transaction', "TransactionController@index")->name("transaction.index");
            Route::get('citizen', "CitizenController@index")->name("citizen.index");
            Route::put('update-phone/{id}', 'CitizenController@updatePhone')->name('citizen.update_phone');

            Route::get('/backButton', "HomeController@backButton")->name("backButton");
            Route::post('logout', "Auth\LoginController@logout")->name("session.logout");
            Route::resource('activity_log', 'ActivityLogController')->only('index', 'show');
            Route::get('department_export', 'DepartmentController@exportDepartment');

            Route::controller('RasidJobController')->name('rasid_job.')->prefix('rasid_job')->group(function () {
                Route::get('archive', 'archive')->name('archive');
                Route::post('restore/{id}', 'restore')->name('restore');
                Route::delete('forceDelete/{id}', 'forceDelete')->name('forceDelete');
                Route::get('export', 'export')->name('export');
                Route::get('exportPDF', 'exportPDF')->name('exportPDF');
            });
            Route::controller('ClientController')->name('client.')->prefix('client')->group(function () {
                Route::get('account_orders', 'accountOrders')->name('account_orders');
            });
            Route::controller('DepartmentController')->name('department.')->prefix('department')->group(function () {
                Route::get('archive', 'archive')->name('archive');
                Route::post('restore/{id}', 'restore')->name('restore');
                Route::delete('forceDelete/{id}', 'forceDelete')->name('forceDelete');
                Route::get('export', 'export')->name('export');
                Route::get('exportPDF', 'exportPDF')->name('exportPDF');
            });

            Route::controller('AdminController')->name('admin.')->prefix('admin')->group(function () {

                Route::get('all-employees/{department}', 'getEmployeesByDepartment');
            });
            Route::controller('ActivityLogController')->name('activitylog.')->prefix('activitylog')->group(function () {

                Route::get('sub-programs/{main?}', 'getSubPrograms')->name('sub_programs');

                Route::get('all-employees/{department}', 'getEmployees')->name('getEmployees');
            });




            Route::resources([
                'rasid_job' => 'RasidJobController',
                'department' => 'DepartmentController',
                'group' => 'GroupController',
                'client' => 'ClientController',
                'citizen' => 'CitizenController',
                'employee' => 'EmployeeController',
                'admin' => 'AdminController',
                'activity_log' => 'ActivityLogController',
                'bank_account' => 'BankAccountController',
                'bank' => 'BankController',
                'card_package' => 'CardPackageController',
            ]);
        });
    }
);
