<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('artisan_commend/{command}', function ($command) {
    ini_set('max_execution_time', 300);
    if ($command) {
        Artisan::call($command);
    }
});
Route::get('cmd_commend/{command}', function ($command) {
    ini_set('max_execution_time', 300);
    if ($command) {
        exec($command, $output);
        return $output;
    }
});

Route::middleware('maintenance_mode')->group(function () {
    Route::post('login', "Auth\LoginController@login");
    Route::post('otp_login', "Auth\LoginController@otpLogin");
    Route::post('send', "Auth\LoginController@sendCode");
    Route::post('resend_code', "Auth\LoginController@resendCode");
    Route::post('check_code', "Auth\ResetPasswordController@CheckResetCode");
    Route::post('reset_password', "Auth\ResetPasswordController@resetPassword");
    Route::get('get_all_trans', 'LocalizationController@getAllTranslations');

    Route::get('countries', 'CountryController@index');
    Route::get("/files/client/{file}", [\App\Http\Controllers\Api\V1\Dashboard\PrivateController::class, "downloadfile"]);
    Route::delete('deletefile/{id}', "PrivateController@deletefile");
    Route::delete('deleteattachments/{id}', "PrivateController@deleteattachments");
    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/home', "HomeController@index")->name("home.index");

        // Public Routes
        Route::post('logout', "Auth\LoginController@logout");
        Route::apiResource('notifications', 'NotificationController')->except('store');
        Route::apiResource('menus', 'MenuController');
        Route::get('group-permissions/{group}', 'GroupController@getPermissionsOfGroup');
        Route::get('permissions', 'GroupController@permissions');
        Route::get('has_permissions/{route_name}', 'GroupController@checkIfUserHasPermission');
        Route::post('validate', 'ValidateController');

        Route::controller('ProfileController')->name('profiles.')->prefix('profile')->group(function () {
            Route::get('show', 'show')->name('show');
            Route::post('update', 'update')->name('update');
            Route::post('change_password', 'changePassword')->name('change_password');
        });
        Route::post('settings/create-setting', 'SettingController@createSetting');
        Route::get('all-departments', 'DepartmentController@getAllDepartments');
        Route::get('all-employees/{department}', 'EmployeeController@getEmployeesByDepartment');
        Route::get('all-groups/{except_id?}', 'GroupController@getGroups');
        Route::get('all-jobs/{department}', 'RasidJobController@getVacantJobs');
        Route::get('all-admins', 'AdminController@getAllAdmins');
        Route::get('all_static_pages', 'StaticPageController@getAllStaticPages');
        Route::get('all-message-types', 'MessageTypeController@getAllMessageTypes');



        Route::controller('ActivityController')->name('activity_logs.')->prefix('activity_logs')->group(function () {
            Route::get('employees', 'getEmployees')->name('employees');
            Route::get('main-programs', 'ActivityController@getMainPrograms')->name('main_programs');
            Route::get('sub-programs/{main?}', 'ActivityController@getSubPrograms')->name('sub_programs');
            Route::get('events', 'ActivityController@getEvents')->name('events');
        });

        Route::delete('delete-image/{appMedia}', 'DeleteImageController')->name('image_delete');

        Route::middleware('adminPermission')->group(function () {
            // Route::controller('CountryController')->name('countries.')->prefix('countries')->group(function () {
            //     Route::get('archive', 'archive')->name('archive');
            //     Route::post('restore/{id}', 'restore')->name('restore');
            //     Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
            // });
            //
            // Route::controller('CurrencyController')->name('currencies.')->prefix('currencies')->group(function () {
            //     Route::get('archive', 'archive')->name('archive');
            //     Route::post('restore/{id}', 'restore')->name('restore');
            //     Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
            // });
            //
            // Route::controller('CityController')->name('cities.')->prefix('cities')->group(function () {
            //     Route::get('archive', 'archive')->name('archive');
            //     Route::post('restore/{id}', 'restore')->name('restore');
            //     Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
            // });
            //
            // Route::controller('RegionController')->name('regions.')->prefix('regions')->group(function () {
            //     Route::get('archive', 'archive')->name('archive');
            //     Route::post('restore/{id}', 'restore')->name('restore');
            //     Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
            // });
            Route::controller('AdminController')->name('admins.')->prefix('admins')->group(function () {
                Route::get('create', 'create')->name('create');
                // Route::get('archive', 'archive')->name('archive');
                // Route::post('restore/{id}', 'restore')->name('restore');
                // Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
            });

            Route::controller('DepartmentController')->name('departments.')->prefix('departments')->group(function () {
                Route::get('archive', 'archive')->name('archive');
                Route::post('restore/{id}', 'restore')->name('restore');
                Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
                // Route::get('get-parents', 'getAllParents')->name("get_parents");
            });

            Route::controller('CitizenController')->name('citizens.')->prefix('citizens')->group(function () {
                Route::get('enabled-cards', 'enabledPackages')->name('enabled_packages');
            });

            Route::controller('RasidJobController')->name('rasid_jobs.')->prefix('rasid_jobs')->group(function () {
                Route::get('archive', 'archive')->name('archive');
                Route::post('restore/{id}', 'restore')->name('restore');
                Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
            });

            // Route::controller('NotificationController')->name('notifications.')->prefix('notifications')->group(function () {
            //     Route::post('store', 'store')->name('store');
            // });

            // Route::controller('EmployeeController')->name('employees.')->prefix('employees')->group(function () {
            //     Route::put('ban/{employee}', 'ban')->name('ban');
            // });

            Route::controller('ContactController')->name('contacts.')->prefix('contacts')->group(function () {
                Route::post('reply', 'reply')->name('reply');
                Route::post('assign-contact/{contact}', 'assignContact')->name('assign_contact');
                Route::delete('delete-contact/{id}', 'deleteContact')->name('delete_contact');
                Route::delete('delete-reply/{id}', 'deleteReply')->name('delete_reply');
            });
            // Route::controller('BankController')->name('banks.')->prefix('banks')->group(function () {
            //     Route::get('archive', 'archive')->name('archive');
            //     Route::post('restore/{id}', 'restore')->name('restore');
            //     Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
            //     Route::get('banks-types', 'bankTypes')->name('banks_types');
            //     Route::get('edit-show/{bank}', 'editShow')->name('edit');
            // });

            Route::controller('VendorPackageController')->name('vendor_package.')->prefix('vendor_package')->group(function () {
                Route::get('get_vendors', 'getVendors')->name('get_vendors');
            });

            Route::controller('TransactionController')->name('transactions.')->prefix('transactions')->group(function () {
                Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
                Route::get('/get-transactions-statuses', 'transactionsStatues')->name('transactions_statues');
            });

            Route::controller('VendorBranchController')->name('vendor_branches.')->prefix('vendor_branches')->group(function () {
                Route::get('get_vendors', 'getVendors')->name('get_vendors');
            });

            Route::apiResources([
                //            'countries' => 'CountryController',
                // 'currencies' => 'CurrencyController',
                // "cities" => "CityController",
                // "regions" => "RegionController",
                "departments" => "DepartmentController",
                'admins' => 'AdminController',
                // 'employees' => 'EmployeeController',
                // 'clients' => 'ClientController',
                'vendors' => 'VendorController',
                'vendor_branches'=>'VendorBranchController',
                'our_apps'=>'OurAppController',
                'rasid_jobs' => 'RasidJobController',
                'banks' => 'BankController',
                'transfer_purposes' => 'TransferPurposeController',
                // 'slides' => 'SlideController',
                "vendor_package" => "VendorPackageController",
                'transactions' => 'TransactionController',
                'static_pages' => 'StaticPageController',
                'faqs'         => 'FaqController',
                'contacts'     => 'ContactController',
                'message_types' => 'MessageTypeController'
            ]);

            Route::apiResource('vendor_branches', 'VendorBranchController')->except('get_vendors');
            Route::apiResource('vendor_package', 'VendorPackageController')->except('get_vendors','show');
            Route::apiResource('citizens', 'CitizenController')->only('index', 'show', 'update');
            Route::apiResource('settings', 'SettingController')->only(['index', 'store']);
            Route::apiResource('links', 'LinkController')->only(['index','update']);
            Route::apiResource('activity_logs', 'ActivityController')->only(['index', 'show']);
            Route::post('localizations_update','LocalizationController@updateTranslation')->name('localizations_update');
            Route::apiResource('localizations', 'LocalizationController')->only(['store', 'index']);


            Route::resource('groups', 'GroupController')->except('create', 'edit', 'destroy');

        });
    });
});
