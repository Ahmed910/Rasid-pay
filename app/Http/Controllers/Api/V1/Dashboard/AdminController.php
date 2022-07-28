<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\AdminRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\{UserResource, Admin\AdminCollection};
use App\Http\Resources\Dashboard\Admin\AllAdminResource;
use App\Models\{Admin, User, Permission, Group\Group, Employee};
use App\Models\Department\Department;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        request()->user_type = "admin";
        $users = User::CustomDateFromTo($request)
            ->has('employee')
            ->search($request)
            ->with(['department', 'permissions', 'groups' => function ($q) {
                $q->with('permissions');
            }])->where('user_type', 'admin')
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' => '',
                'departments' => Department::ListsTranslations('name')->without(['images', 'addedBy'])->get()
            ]);
    }

    public function archive(Request $request)
    {
        $users = User::onlyTrashed()->where('user_type', 'admin')->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));
        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' => ''
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
                'message' => '',
            ]);
    }


    public function store(AdminRequest $request, User $admin)
    {
        $admin->fill([
            'user_type' => 'admin', 'added_by_id' => auth()->id(),
        ] + $request->validated())->save();
        $employee = Employee::create($request->safe()->only(['department_id', 'rasid_job_id']) + ['user_id' => $admin->id]);
        $employee->job()->update(['is_vacant' => 0]);
        $admin->admin()->create();
        //TODO::send sms with password
        $permissions = $request->permission_list ?? [];
        $all_permissions = Permission::select('id', 'name')->get();
        $permissions_collect = $all_permissions->whereIn('id', $permissions);
        foreach ($permissions_collect as $permission) {
            $action = explode('.', $permission->name);
            if (in_array(@$action[1], ['update', 'store', 'destroy', 'show']) && !$permissions_collect->contains('name', $action[0] . '.index')) {
                $permissions[] = $all_permissions->where('name', $action[0] . '.index')->first()?->id;
            } elseif (in_array(@$action[1], ['restore', 'force_delete']) && !$permissions_collect->contains('name', $action[0] . '.archive')) {
                $permissions[] = $all_permissions->where('name', $action[0] . '.archive')->first()?->id;
            }
        }
        if ($request->group_list) {
            $admin->groups()->sync($request->group_list);
            $permissions = array_filter(array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray()));
        }
        $admin->permissions()->sync($permissions);
        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_add'),
            ]);
    }

    public function show(Request $request, $id)
    {
        $admin = User::withTrashed()->where('user_type', 'admin')->with('admin')->findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            if ($admin->admin) {
                $activities = $admin->admin->activity()
                    ->sortBy($request)
                    ->paginate((int)($request->per_page ??  config("globals.per_page")));
            }
        }

        return AdminCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function update(AdminRequest $request, User $admin)
    {
        if ($request->password_change && $request->password_change == 1) {
            $admin->fill($request->validated() + ['updated_at' => now()])->save();
        } else {
            $admin->fill($request->safe()->except(['password']) + ['updated_at' => now()])->save();
        };
        $admin->admin()->updateOrCreate(['user_id' => $admin->id], $request->only(['ban_status', 'ban_from', 'ban_to']) + ['updated_at' => now()]);
        $admin->employee->update($request->safe()->only(['department_id', 'rasid_job_id']));
        $admin->employee->job()->update(['is_vacant' => 0]);

        //TODO::send sms with password
        // if($request->('password_change'))
        $permissions = $request->permission_list ?? [];
        $all_permissions = Permission::select('id', 'name')->get();
        $permissions_collect = $all_permissions->whereIn('id', $permissions);
        foreach ($permissions_collect as $permission) {
            $action = explode('.', $permission->name);
            if (in_array(@$action[1], ['update', 'store', 'destroy', 'show']) && !$permissions_collect->contains('name', $action[0] . '.index')) {
                $permissions[] = $all_permissions->where('name', $action[0] . '.index')->first()?->id;
            } elseif (in_array(@$action[1], ['restore', 'force_delete']) && !$permissions_collect->contains('name', $action[0] . '.archive')) {
                $permissions[] = $all_permissions->where('name', $action[0] . '.archive')->first()?->id;
            }
        }
        if ($request->group_list) {
            $admin->groups()->sync($request->group_list);
            $permissions = array_filter(array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray()));
        }
        $admin->permissions()->sync($permissions);

        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_update'),
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

    public function getAllAdmins(Request $request)
    {

        $users = User::where('user_type', 'admin')
        ->when($request->has_permission_on && is_array($request->has_permission_on),function($q) use($request){
            $q->whereHas('permissions',function($q) use($request){
                $q->whereIn('main_program',$request->has_permission_on);

            })->where('users.id','!=',auth()->id());
        })
            ->get();

        return AllAdminResource::collection($users)
            ->additional([
                'status' => true,
                'message' => '',

            ]);
    }
}
