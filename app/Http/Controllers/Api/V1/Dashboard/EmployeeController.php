<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\EmployeeRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index(Request $request)
    {
        $employees = Employee::with(['user' => function ($q) {
            $q->with('addedBy');
        }])
            ->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));

        return EmployeeResource::collection($employees)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }

    // public function archive(Request $request)
    // {
    //     $users = User::onlyTrashed()->where('user_type', 'employee')->select('id', 'fullname', 'email', 'whatsapp', 'gender', 'is_active', 'created_at')->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));
    //     return EmployeeResource::collection($users)
    //         ->additional([
    //             'status' => true,
    //             'message' =>  ''
    //         ]);
    // }

    public function create()
    {
        //
    }


    public function store(EmployeeRequest $request, User $user)
    {
        $user->fill($request->safe()->except(['contract_type', 'salary', 'qr_path', 'qr_code', 'department_id', 'rasid_job_id'])  + ['user_type' => 'employee', 'added_by_id' => auth()->id()])->save();
        $employee = Employee::create($request->safe()->only(['contract_type', 'salary', 'qr_path', 'qr_code', 'department_id', 'rasid_job_id']) + ['user_id' => $user->id]);
        $employee->job()->update(['is_vacant' => false]);
        $employee->load('user');
        return EmployeeResource::make($employee)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_add'),
            ]);
    }


    public function show($id)
    {
        $employee = Employee::with(['user' => function ($q) {
            $q->with('addedBy');
        }])->where('user_id', $id)->firstOrFail();
        return EmployeeResource::make($employee)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }


    public function edit($id)
    {
        //
    }


    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::where('user_id', $id)->firstOrFail();
        $old_job = $employee->job;
        $employee->update($request->safe()->only(['contract_type', 'salary', 'qr_path', 'qr_code', 'department_id', 'rasid_job_id']));
        $employee->user()->update($request->safe()->except(['contract_type', 'salary', 'qr_path', 'qr_code', 'department_id', 'rasid_job_id']));

        if ($old_job->id != $request->rasid_job_id) {
            $employee->job()->update(['is_vacant' => false]);
            $old_job->update(['is_vacant' => true]);
        }

        $employee->load('user');
        return EmployeeResource::make($employee)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_update'),
            ]);
    }

    public function getEmployeesByDepartment($id)
    {
        return response()->json([
            'data' => User::select('id','fullname')->where('user_type','employee')->whereHas('department',function ($q) use($id) {
                $q->where('departments.id',$id);
            })->setEagerLoads([])->get(),
            'status' => true,
            'message' =>  '',
        ]);
    }

    //archive data
    // public function destroy(ReasonRequest $request, $id)
    // {
    //     $employee = Employee::where('user_id', $id)->firstOrFail();
    //     $employee->delete();
    //     return EmployeeResource::make($employee)
    //         ->additional([
    //             'status' => true,
    //             'message' =>  trans('dashboard.general.success_archive'),
    //         ]);
    // }

    //restore data from archive
    // public function restore(ReasonRequest $request, $employee)
    // {
    //     $employee = User::onlyTrashed()->where('user_type', 'employee')->findOrFail($employee);
    //     $employee->restore();

    //     return EmployeeResource::make($employee)
    //         ->additional([
    //             'status' => true,
    //             'message' =>  trans('dashboard.general.success_restore'),
    //         ]);
    // }

    //force delete data from archive
    // public function forceDelete(ReasonRequest $request, $employee)
    // {
    //     $employee = User::onlyTrashed()->where('user_type', 'employee')->findOrFail($employee);
    //     $employee->forceDelete();

    //     return EmployeeResource::make($employee)
    //         ->additional([
    //             'status' => true,
    //             'message' =>  trans('dashboard.general.success_delete'),
    //         ]);
    // }
}
