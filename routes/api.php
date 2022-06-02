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

Route::get('host_url/{type}', function ($type) {
    $host = \DB::table('vue_domains')->where(['is_active' => 1, 'domain_type' => $type])->latest()->first();
    return response()->json([
        'data' => ['host' => $host->domain],
        'message' => '',
        'status' => true,
        ]);
});
