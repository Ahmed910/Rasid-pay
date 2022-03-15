<?php

namespace App\Http\Controllers\Blade\V1\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.home.index');
    }

}
