<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.home.index');
    }

    public function backButton()
    {
        $sessionVal = session('perviousPage');

        if ($sessionVal && $sessionVal != 'home')
            return redirect()->route('dashboard.'.$sessionVal.'.index');
        else
            return redirect()->route('dashboard.home.index');
    }
}
