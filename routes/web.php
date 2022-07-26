<?php

use App\Models\Contact;
use Illuminate\Support\Arr;
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
    $contact = Contact::create([
        'fullname' => 'Mohamed',
        'email' => 'mohamed@yahoo.com',
        'phone' => '0100200300',
        'content' => 'tes message',
    ]);
    return $contact;
});
