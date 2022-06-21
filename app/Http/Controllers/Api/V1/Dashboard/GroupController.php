<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\GroupRequest;
use App\Http\Resources\Dashboard\Group\{GroupResource, GroupCollection, PermissionResource, UriResource};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{Group\Group, Permission};

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = Group::with('groups', 'permissions')
            ->withTranslation()
            ->search($request)
            ->sortBy($request)
            ->withCount('admins as user_count')
            ->paginate((int)($request->per_page ??  config("globals.per_page")));

        return GroupResource::collection($groups)->additional(['status' => true, 'message' => ""]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request, Group $group)
    {
        $group->fill($request->validated() + ['added_by_id' => auth()->id()])->save();
        $permissions = $request->permission_list ?? [];
        $all_permissions = Permission::select('id', 'name')->get();
        $permissions_collect = $all_permissions->whereIn('id', $request->permission_list);
        foreach ($permissions_collect as $permission) {
            $action = explode('.', $permission->name);
            if (in_array(@$action[1], ['update', 'store', 'destroy', 'show']) && !$permissions_collect->contains('name', $action[0] . '.index')) {
                $permissions[] = $all_permissions->where('name', $action[0] . '.index')->first()?->id;
            } elseif (in_array(@$action[1], ['restore', 'force_delete']) && !$permissions_collect->contains('name', $action[0] . '.archive')) {
                $permissions[] = $all_permissions->where('name', $action[0] . '.archive')->first()?->id;
            }
        }
        if ($request->group_list) {
            $group->groups()->sync($request->group_list);
            $permissions = array_filter(array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray()));
        }
        $group->permissions()->sync($permissions);
        return GroupResource::make($group)->additional(['status' => true, 'message' => trans('dashboard.general.success_add')]);
    }

    public function show(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $group->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }
        return GroupCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function checkIfUserHasPermission(Request $request, $route_name)
    {
        $has_access = auth()->user()->hasPermissions($route_name);
        return response()->json([
            'data' => null,
            'status' => $has_access,
            'message' => ''
        ], $has_access ? 200 : 403);
    }

    public function getPermissionsOfGroup(Group $group, Request $request)
    {
        $permissions = $group->permissions()->sortBy($request)->paginate((int)($request->per_page ??  config("globals.per_page")));

        return PermissionResource::collection($permissions)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, Group $group)
    {
        $old_permissions = $group->permission_list;
        $group->fill($request->validated() + ['updated_at' => now()])->save();
        $permissions = $request->permission_list ?? [];
        $all_permissions = Permission::select('id', 'name')->get();
        $permissions_collect = $all_permissions->whereIn('id', $request->permission_list);
        foreach ($permissions_collect as $permission) {
            $action = explode('.', $permission->name);
            if (in_array($action[1], ['update', 'store', 'destroy', 'show']) && !$permissions_collect->contains('name', $action[0] . '.index')) {
                $permissions[] = $all_permissions->where('name', $action[0] . '.index')->first()?->id;
            } elseif (in_array($action[1], ['restore', 'force_delete']) && !$permissions_collect->contains('name', $action[0] . '.archive')) {
                $permissions[] = $all_permissions->where('name', $action[0] . '.archive')->first()?->id;
            }
        }
        if ($request->group_list) {
            $permissions = array_filter(array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray()));
        }

        $shared_permissions = array_intersect($old_permissions, $permissions);
        $attached_permissions = array_diff($permissions, $shared_permissions);
        $detached_permissions = array_diff($old_permissions, $shared_permissions);
        if ($attached_permissions || $detached_permissions) {
            $group->admins?->each(function ($admin) use ($attached_permissions, $detached_permissions) {
                if ($detached_permissions) {
                    $admin->permissions()->detach($detached_permissions);
                }
                $new_permissions = array_diff($attached_permissions, $admin->permission_list);
                if ($new_permissions) {
                    $admin->permissions()->syncWithoutDetaching($new_permissions);
                }
            });
        }

        $group->groups()->sync($request->group_list);
        $group->permissions()->sync($permissions);
        return GroupResource::make($group)->additional(['status' => true, 'message' => trans('dashboard.general.success_update')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        $group->admins?->each(function ($user) {
            $user->permissions()->detach();
        });
        return GroupResource::make($group)->additional(['status' => true, 'message' => trans('dashboard.general.success_delete')]);
    }

    public function permissions(Request $request)
    {
        return UriResource::collection(Permission::getPermissions())->additional(['status' => true, 'message' => '']);
    }

    public function getGroups(Request $request, $group_id = null)
    {
        $groups = Group::when($group_id, function ($q) use ($group_id) {
            $q->where('groups.id', "<>", $group_id);
        })->when($request->activate_case, function ($q) use ($request) {
            switch ($request->activate_case) {
                case 'active':
                    $q->where('is_active', 1);
                    break;
                case 'hold':
                    $q->where('is_active', 0);
                    break;
            }
        })->with('permissions')->ListsTranslations('name')->without(['addedBy'])->get();

        return GroupResource::collection($groups)->additional(['status' => true, 'message' => ""]);
    }
}
