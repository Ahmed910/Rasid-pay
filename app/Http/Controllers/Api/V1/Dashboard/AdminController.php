<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\AdminRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\UserResource;
use App\Models\{User, Group\Group};
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $users = User::with(['department', 'groups' , 'permissions'])->where('user_type', 'admin')->latest()->paginate((int)($request->perPage ?? 10));

        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }

    public function archive(Request $request)
    {
        $users = User::onlyTrashed()->where('user_type', 'admin')->latest()->paginate((int)($request->perPage ?? 10));
        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' =>  ''
            ]);
    }

    public function create(Request $request)
    {
        $users = User::with(['department', 'groups' , 'permissions'])->where('user_type', 'employee')->latest()->get();

        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }


    public function store(AdminRequest $request)
    {
        $admin = User::where('user_type', 'employee')->findOrFail($request->employee_id);
        $admin->update(['user_type' => 'admin', 'password' => $request->password, 'added_by_id' => auth()->id(), 'is_login_code' => $request->is_login_code, 'login_id' => $request->login_id]);
        //TODO::send sms with password
        $permissions = $request->permission_list;
        if ($request->group_list) {
            $admin->groups()->sync($request->group_list);
            $permissions = array_filter(array_merge($permissions , Group::find($request->group_list)->pluck('permissions')->pluck('id')->unique()->toArray()));
        }
        $admin->permissions()->sync($permissions);
        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_add'),
            ]);
    }


    public function show($id)
    {
        $user = User::withTrashed()->where('user_type', 'admin')->with(['addedBy', 'country', 'groups' , 'permissions'])->findOrFail($id);

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


    public function update(AdminRequest $request, $admin)
    {
        $admin = User::where('user_type', 'admin')->findOrFail($admin);
        $admin->fill($request->validated())->save();

        //TODO::send sms with password
        // if($request->('password_change'))
        $permissions = $request->permission_list;
        if ($request->group_list) {
            $admin->groups()->sync($request->group_list);
            $permissions = array_filter(array_merge($permissions , Group::find($request->group_list)->pluck('permissions')->pluck('id')->unique()->toArray()));
        }
        $admin->permissions()->sync($permissions);

        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_update'),
            ]);
    }

    //archive data
    public function destroy(ReasonRequest $request, $admin)
    {
        $admin = User::where('user_type', 'admin')->findOrFail($admin);
        $admin->delete();
        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_archive'),
            ]);
    }

    //restore data from archive
    public function restore(ReasonRequest $request, $id)
    {
        $admin = User::onlyTrashed()->where('user_type', 'admin')->findOrFail($id);
        $admin->restore();

        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_restore'),
            ]);
    }

    //force delete data from archive
    public function forceDelete(ReasonRequest $request, $id)
    {
        $admin = User::onlyTrashed()->where('user_type', 'admin')->findOrFail($id);
        $admin->forceDelete();

        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_delete'),
            ]);
    }
}
