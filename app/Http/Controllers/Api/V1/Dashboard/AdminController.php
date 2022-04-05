<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\AdminRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\{UserResource, Admin\AdminCollection};
use App\Models\{User, Group\Group};
use App\Models\Department\Department;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $users = User::CustomDateFromTo($request)->search($request)->with(['department', 'permissions', 'groups' => function ($q) {
            $q->with('permissions');
        }])->where('user_type', 'admin')
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        // $users = User::CustomSearch($request)->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));

        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' =>  '',
                'departments' => Department::ListsTranslations('name')->without(['images', 'addedBy'])->get()
            ]);
    }

    public function archive(Request $request)
    {
        $users = User::onlyTrashed()->where('user_type', 'admin')->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));
        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' =>  ''
            ]);
    }

    public function create(Request $request)
    {
        $users = User::with(['department', 'permissions', 'groups' => function ($q) {
            $q->with('permissions');
        }])->where('user_type', 'employee')->latest()->get();

        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }


    public function store(AdminRequest $request)
    {
        $admin = User::where('user_type', 'employee')->findOrFail($request->employee_id);
        $admin->fill(['user_type' => 'admin', 'password' => $request->password, 'added_by_id' => auth()->id(), 'is_login_code' => $request->is_login_code, 'login_id' => $request->login_id])->save();
        $admin->admin()->create();
        //TODO::send sms with password
        $permissions = $request->permission_list ?? [];
        if ($request->group_list) {
            $admin->groups()->sync($request->group_list);
            $permissions = array_filter(array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray()));
        }
        $admin->permissions()->sync($permissions);
        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_add'),
            ]);
    }

    public function show(Request $request, $id)
    {
        $admin = User::withTrashed()->where('user_type', 'admin')->with('admin')->findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $admin->admin->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ?? 15));
        }

        return AdminCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function update(AdminRequest $request, $id)
    {
        $admin = User::where('user_type', 'admin')->findOrFail($id);

        if ($request->password_change && $request->password_change == 1) {
            $admin->fill($request->validated()+['updated_at' => now()])->save();
        }else{
            $admin->fill($request->safe()->except(['password'])+['updated_at' => now()])->save();
        };
        $admin->admin->update($request->only(['ban_status','ban_from','ban_to'])+['updated_at' => now()]);

        //TODO::send sms with password
        // if($request->('password_change'))
        $permissions = $request->permission_list ?? [];
        if ($request->group_list) {
            $admin->groups()->sync($request->group_list);
            $permissions = array_filter(array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray()));
        }
        $admin->permissions()->sync($permissions);

        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_update'),
            ]);
    }

    //archive data
    // public function destroy(ReasonRequest $request, $admin)
    // {
    //     $admin = User::where('user_type', 'admin')->findOrFail($admin);
    //     $admin->delete();
    //     return UserResource::make($admin)
    //         ->additional([
    //             'status' => true,
    //             'message' =>  __('dashboard.general.success_archive'),
    //         ]);
    // }

    //restore data from archive
    // public function restore(ReasonRequest $request, $id)
    // {
    //     $admin = User::onlyTrashed()->where('user_type', 'admin')->findOrFail($id);
    //     $admin->restore();

    //     return UserResource::make($admin)
    //         ->additional([
    //             'status' => true,
    //             'message' =>  __('dashboard.general.success_restore'),
    //         ]);
    // }

    //force delete data from archive
    // public function forceDelete(ReasonRequest $request, $id)
    // {
    //     $admin = User::onlyTrashed()->where('user_type', 'admin')->findOrFail($id);
    //     $admin->forceDelete();

    //     return UserResource::make($admin)
    //         ->additional([
    //             'status' => true,
    //             'message' =>  __('dashboard.general.success_delete'),
    //         ]);
    // }
}
