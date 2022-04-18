<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Department\Department;
use App\Models\Employee;
use App\Models\RasidJob\RasidJob;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $departments=Department::count();
        $employees=Employee::count();
        $Active_users=User::where('ban_status','active')->where('user_type', 'admin')->count();
        $permanent_users=User::where('ban_status','permanent')->count();
        $temporary_users=User::where('ban_status','temporary')->count();
        $vacant_jobs=RasidJob::where('is_vacant',1)->count();
        $unvacant_jobs=RasidJob::where('is_vacant',0)->count();

        return view('dashboard.home.index',compact('departments','employees','Active_users','temporary_users','permanent_users','vacant_jobs','unvacant_jobs'));
    }

    public function backButton()
    {
        $sessionVal = session('perviousPage');
        session()->forget('perviousPage');
        if ($sessionVal && $sessionVal != 'home')
            return redirect()->route('dashboard.' . $sessionVal . '.index');
        else
            return redirect()->route('dashboard.home.index');
    }
}
