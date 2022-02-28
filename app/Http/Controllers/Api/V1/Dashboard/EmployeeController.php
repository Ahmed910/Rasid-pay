<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\EmployeeRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\EmployeeResource;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index(Request $request)
    {
        $users = User::with('department')->where('user_type', 'employee')->select('id', 'fullname', 'email', 'whatsapp', 'gender', 'is_active', 'created_at', 'is_active')->latest()->paginate((int)($request->perPage ?? 10));

        return EmployeeResource::collection($users)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }

    public function archive(Request $request)
    {
        $users = User::onlyTrashed()->where('user_type', 'employee')->select('id', 'fullname', 'email', 'whatsapp', 'gender', 'is_active', 'created_at')->latest()->paginate((int)($request->perPage ?? 10));
        return EmployeeResource::collection($users)
            ->additional([
                'status' => true,
                'message' =>  ''
            ]);
    }

    public function create()
    {
        //
    }


    public function store(EmployeeRequest $request, User $user)
    {
        $user->fill($request->validated() + ['added_by_id' => auth()->id(), 'user_type' => 'employee'])->save();

        return EmployeeResource::make($user)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_add'),
            ]);
    }


    public function show($id)
    {
        $user = User::withTrashed()->where('user_type', 'employee')->with(['addedBy', 'country', 'role'])->findOrFail($id);

        return EmployeeResource::make($user)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }


    public function edit($id)
    {
        //
    }


    public function update(EmployeeRequest $request, $employee)
    {
        $employee = User::where('user_type', 'employee')->findOrFail($employee);
        $employee->update($request->validated());

        return EmployeeResource::make($employee)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_update'),
            ]);
    }

    //archive data
    public function destroy(ReasonRequest $request, $employee)
    {
        $employee = User::where('user_type', 'employee')->findOrFail($employee);
        $employee->delete();
        return EmployeeResource::make($employee)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_archive'),
            ]);
    }

    //restore data from archive
    public function restore(ReasonRequest $request, $employee)
    {
        $employee = User::onlyTrashed()->where('user_type', 'employee')->findOrFail($employee);
        $employee->restore();

        return EmployeeResource::make($employee)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_restore'),
            ]);
    }

    //force delete data from archive
    public function forceDelete(ReasonRequest $request, $employee)
    {
        $employee = User::onlyTrashed()->where('user_type', 'employee')->findOrFail($employee);
        $employee->forceDelete();

        return EmployeeResource::make($employee)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_delete'),
            ]);
    }
}
