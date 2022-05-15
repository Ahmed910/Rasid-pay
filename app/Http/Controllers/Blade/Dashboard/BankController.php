<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Department\Department;
use App\Models\Employee;
use App\Models\RasidJob\RasidJob;
use App\Models\User;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.bank.index');
    }

    public function create(Request $request)
    {
        return view('dashboard.bank.create');
    }
    public function show(Request $request)
    {
        return view('dashboard.bank.show');
    }
 
}
