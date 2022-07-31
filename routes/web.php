<?php

use App\Models\Contact;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
    $settings = Setting::select('value->en', 'key')->get();
    $fp = fopen('settings.csv', 'w');

    // Loop through file pointer and a line
    foreach ($settings as $fields) {
        fputcsv($fp, $fields);
    }

    fclose($fp);
});
