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

Route::controller('ActivityController')->name('activity_logs.')->prefix('activity_logs')->group(function () {
    Route::get('export_pdf', 'exportPDF')->name('export_pdf');
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
            Route::put('update', 'update')->name('update');
            // Route::post('change_password', 'changePassword')->name('change_password');
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
            // Route::get('export_pdf', 'exportPDF')->name('export_pdf');
            Route::get('export_excel', 'exportExcel')->name('export_excel');

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
                Route::get('{admin}/edit', 'show')->name('edit');
                // Route::get('archive', 'archive')->name('archive');
                // Route::post('restore/{id}', 'restore')->name('restore');
                // Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });

            Route::controller('DepartmentController')->name('departments.')->prefix('departments')->group(function () {
                Route::get('archive', 'archive')->name('archive');
                Route::get('{department}/edit', 'show')->name('edit');
                Route::post('restore/{id}', 'restore')->name('restore');
                Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
                // Route::get('get-parents', 'getAllParents')->name("get_parents");
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
                Route::get('archive/export_pdf', 'exportPDFArchive')->name('archive.export_pdf');
                Route::get('archive/export_excel', 'exportExcelArchive')->name('archive.export_excel');
            });

            Route::controller('CitizenController')->name('citizens.')->prefix('citizens')->group(function () {
                Route::get('{citizen}/edit', 'show')->name('edit');
                Route::get('enabled-cards', 'enabledPackages')->name('enabled_packages');
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });

            Route::controller('RasidJobController')->name('rasid_jobs.')->prefix('rasid_jobs')->group(function () {
                Route::get('archive', 'archive')->name('archive');
                Route::get('{rasid_job}/edit', 'show')->name('edit');
                Route::post('restore/{id}', 'restore')->name('restore');
                Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
                Route::get('export_pdf', 'exportPDF')->name('exportPDF');
                Route::get('export_excel', 'exportExcel')->name('exportExcel');
                Route::get('archive/export_pdf', 'exportPDFArchive')->name('archive.exportPDFArchive');
                Route::get('archive/export_excel', 'exportExcelArchive')->name('archive.exportExcelArchive');
            });

            // Route::controller('NotificationController')->name('notifications.')->prefix('notifications')->group(function () {
            //     Route::post('store', 'store')->name('store');
            // });

            Route::controller('GroupController')->name('groups.')->prefix('groups')->group(function () {
                Route::get('{group}/edit', 'show')->name('edit');
            });

            Route::controller('ContactController')->name('contacts.')->prefix('contacts')->group(function () {
                Route::post('reply', 'reply')->name('reply');
                Route::post('assign-contact/{contact}', 'assignContact')->name('assign_contact');
                Route::get('{contact}/edit', 'show')->name('edit');
                // Route::delete('delete-contact/{id}', 'deleteContact')->name('delete_contact');
                // Route::delete('delete-reply/{id}', 'deleteReply')->name('delete_reply');
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });
            Route::controller('BankController')->name('banks.')->prefix('banks')->group(function () {
                // Route::get('archive', 'archive')->name('archive');
                // Route::post('restore/{id}', 'restore')->name('restore');
                // Route::delete('forceDelete/{id}', 'forceDelete')->name('force_delete');
                // Route::get('banks-types', 'bankTypes')->name('banks_types');
                // Route::get('edit-show/{bank}', 'editShow')->name('edit');
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('{bank}/edit', 'show')->name('edit');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });
            Route::controller('FaqController')->name('faqs.')->prefix('faqs')->group(function () {
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('{faq}/edit', 'show')->name('edit');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });
            Route::controller('GroupController')->name('groups.')->prefix('groups')->group(function () {
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });
            Route::controller('LocalizationController')->name('localizations.')->prefix('localizations')->group(function () {
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });
            Route::controller('MessageTypeController')->name('message_types.')->prefix('message_types')->group(function () {
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('{message_type}/edit', 'show')->name('edit');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });
            Route::controller('OurAppController')->name('our_apps.')->prefix('our_apps')->group(function () {
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('{our_app}/edit', 'show')->name('edit');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });
            Route::controller('StaticPageController')->name('static_pages.')->prefix('static_pages')->group(function () {
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('{static_page}/edit', 'show')->name('edit');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });

            Route::controller('TransferPurposeController')->name('transfer_purposes.')->prefix('transfer_purposes')->group(function () {
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('{transfer_purpose}/edit', 'show')->name('edit');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });
            Route::controller('VendorController')->name('vendors.')->prefix('vendors')->group(function () {
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('{vendor}/edit', 'show')->name('edit');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });
            Route::controller('LinkController')->name('links.')->prefix('links')->group(function () {
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });

            Route::controller('VendorPackageController')->name('vendor_packages.')->prefix('vendor_packages')->group(function () {
                Route::get('get_vendors', 'getVendors')->name('get_vendors');
                Route::get('{vendor_package}/edit', 'show')->name('edit');
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });

            Route::controller('TransactionController')->name('transactions.')->prefix('transactions')->group(function () {
                Route::get('/get-transactions-statuses', 'transactionsStatues');
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
            });

            Route::controller('VendorBranchController')->name('vendor_branches.')->prefix('vendor_branches')->group(function () {
                Route::get('get_vendors', 'getVendors')->name('get_vendors');
                Route::get('{vendor_branch}/edit', 'show')->name('edit');
                Route::get('export_pdf', 'exportPDF')->name('export_pdf');
                Route::get('export_excel', 'exportExcel')->name('export_excel');
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
                'static_pages' => 'StaticPageController',
                'faqs'         => 'FaqController',
                'message_types' => 'MessageTypeController'
            ]);

            Route::apiResource('vendor_branches', 'VendorBranchController')->except('get_vendors');
            Route::apiResource('contacts', 'ContactController')->only('index','show');
            Route::apiResource('vendor_packages', 'VendorPackageController')->except('destroy');
            Route::apiResource('citizens', 'CitizenController')->only('index', 'show', 'update');
            Route::apiResource('settings', 'SettingController')->only(['index', 'store']);
            Route::apiResource('links', 'LinkController')->only(['index','update']);
            Route::apiResource('transactions', 'TransactionController')->except(['update','destroy']);
            Route::apiResource('activity_logs', 'ActivityController')->only(['index', 'show']);
            Route::post('localizations_update','LocalizationController@updateTranslation')->name('localizations.update');
            Route::apiResource('localizations', 'LocalizationController')->only(['store', 'index']);


            Route::resource('groups', 'GroupController')->except('create', 'edit', 'destroy');

        });
    });
});
