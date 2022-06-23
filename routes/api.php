<?php

use Illuminate\Http\Request;
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

Route::get('version', function () {
    $host = \DB::table('app_versions')->latest()->first();
    return response()->json([
        'data' => ['version' => $host?->version, 'website' => setting('website_link') ?? 'alfintech.com.eg'],
        'message' => '',
        'status' => true,
        ]);
});
