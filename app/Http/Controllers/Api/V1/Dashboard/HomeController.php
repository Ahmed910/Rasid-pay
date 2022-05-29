<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department\Department;
use App\Models\Employee;
use App\Models\RasidJob\RasidJob;

class HomeController extends Controller
{
    public function index()
    {

        $data = [
            'active_users'           => User::where('ban_status', 'active')->where('user_type', 'admin')->count(),
            'permanent_banned_users' => User::where('ban_status', 'permanent')->count(),
            'temporary_banned_users' => User::where('ban_status', 'temporary')->count(),
            'departments'            => Department::count(),
            'archived_departments'   => Department::onlyTrashed()->count(),
            'employees'              => Employee::count(),
            'vacant_jobs'            => RasidJob::where('is_vacant', 1)->count(),
            'unvacant_jobs'          => RasidJob::where('is_vacant', 0)->count()
        ];

        return response()->json([
            'data' => [
                'statistics' => $data
            ],
            'status' => true,
            'message' =>  '',
        ]);
    }
}
