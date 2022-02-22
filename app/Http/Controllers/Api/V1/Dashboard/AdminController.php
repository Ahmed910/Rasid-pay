<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\AdminRequest;
use App\Http\Resources\Dashboard\UserResource;
use App\Models\{User , Group};
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $users = User::with(['department', 'group'])->where('user_type', 'admin')->select('id', 'fullname', 'email', 'whatsapp', 'gender', 'is_active', 'created_at')->latest()->paginate((int)($request->perPage ?? 10));

        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }

    public function archive(Request $request)
    {
        $users = User::onlyTrashed()->where('user_type', 'admin')->select('id', 'fullname', 'email', 'whatsapp', 'gender', 'is_active', 'created_at')->latest()->paginate((int)($request->perPage ?? 10));
        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' =>  ''
            ]);
    }

    public function create(Request $request)
    {
        $users = User::with(['department', 'group'])->where('user_type', 'employee')->select('id', 'fullname', 'email', 'whatsapp', 'gender', 'is_active', 'created_at')->latest();

        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }


    public function store(AdminRequest $request)
    {
        $codeStatus = ($request->has('is_login_code') ? 1 : 0);
        $admin = User::updateOrCreate(['id' => $request->employee_id], ['user_type' => 'admin', 'group_id' => $request->group_id, 'password' => $request->password, 'added_by_id' => auth()->id(), 'is_login_code' => $codeStatus]);
        //TODO::send sms with password
        $permissions = $request->permission_list;
        if($request->group_list){
            $permissions[] = Group::find($request->group_list)->pluck('permissions')->pluck('id')->unique()->toArray();
        }
        $admin->permissions()->sync($permissions);
        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_add'),
            ]);
    }


    public function show($id)
    {
        $user = User::withTrashed()->with(['addedBy', 'country', 'group'])->findOrFail($id);

        return UserResource::make($user)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }


    public function edit($id)
    {
        //
    }


    public function update(AdminRequest $request, User $admin)
    {
        $admin->fill($request->validated())->save();

        //TODO::send sms with password
        // if($request->('password_change'))

        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_update'),
            ]);
    }

    //archive data
    public function destroy(User $admin)
    {
        $admin->delete();
        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_archive'),
            ]);
    }

    //restore data from archive
    public function restore($id)
    {
        $admin = User::onlyTrashed()->findOrFail($id);
        $admin->restore();

        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_restore'),
            ]);
    }

    //force delete data from archive
    public function forceDelete($id)
    {
        $admin = User::onlyTrashed()->findOrFail($id);
        $admin->forceDelete();

        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_delete'),
            ]);
    }
}
