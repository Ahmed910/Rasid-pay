<?php

use App\Http\Resources\Dashboard\SimpleUserResource;
use App\Models\User;
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

Route::post('upload-image/', function (Request $request) {
    $data = $request->validate([
        'image' => 'required|max:5120|mimes:jpg,png,jpeg,bmp,mpeg,json,pdf'
    ]);

    $path = $data['image']->storePublicly('images-test', 'public');

    $image =  "/storage/" . $path;

    return response()->json([
        'path' => url('') . $image
    ]);
});


Route::get('test-pagination', function () {
    $departments = User::paginate(3);

    return SimpleUserResource::collection($departments)
        ->additional([
            'message' => '',
            'status' => true,
        ]);
});
