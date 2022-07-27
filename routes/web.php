<?php

use App\Models\Contact;
use App\Models\Permission;
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
    $permission =  Permission::select('id', 'name', 'action', DB::raw("SUBSTRING_INDEX(name,'.',1) as program"))->get();

    $data= $permission->transform(function ($per) {
        $data['id'] = $per->id;
        $data['name'] = $per->name;
        $data['action'] = $per->action;
        if (in_array($per->action, ['update', 'show', 'destroy', 'index'])) {
            $data['sub_program'] = 'index';
        } else if (in_array($per->action, ['restore', 'force_delete'])) {
            $data['sub_program'] = 'archive';
        } else if (in_array($per->action, ['store'])) {
            $data['sub_program'] = 'store';
        } else {
            $data['sub_program'] = '';
        }
        $data['program'] = $per->program;

        return $data;
    });

    // Open a file in write mode ('w')
    $fp = fopen('persons.csv', 'w');

    // Loop through file pointer and a line
    foreach ($data as $fields) {
        fputcsv($fp, $fields);
    }

    fclose($fp);
});
