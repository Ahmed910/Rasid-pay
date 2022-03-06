<?php

namespace App\Http\Controllers\Api\V1\Dashboard;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department\Department;
use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Http\Resources\Dashboard\SimpleEmployeeResource;
use App\Http\Resources\Dashboard\Departments\SimpleDepartmentResource;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $activatyLogs = ActivityLog::latest()->paginate((int)($request->per_page ?? 15));

        return ActivityLogResource::collection($activatyLogs)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }


    public function show(ActivityLog $activityLog)
    {

        return ActivityLogResource::make($activityLog)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
            ]);

    }

    public function getDepartments()
    {
        $departments = Department::get();

        return SimpleDepartmentResource::collection($departments)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }

    public function getEmployees()
    {
        $employees = User::whereIn('user_type',['admin','superadmin'])
                         ->when(request('department_id'), function($employees){
                             $employees->whereHas('employee',function($employees){
                                 $employees->where('department_id', request('department_id'));
                        });
                    })->get();

        return SimpleEmployeeResource::collection($employees)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }





}
