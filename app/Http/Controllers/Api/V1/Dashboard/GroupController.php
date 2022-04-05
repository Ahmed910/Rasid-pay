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
            ->paginate((int)($request->per_page ?? 15));

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
                ->paginate((int)($request->per_page ?? 15));
        }
        return GroupCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function checkIfUserHasPermission(Request $request,$route_name)
    {
        $has_access = auth()->user()->hasPermissions($route_name);
        return response()->json([
                'data' => null,
                'status' => $has_access,
                'message' => ''
            ],$has_access ? 200 : 403);
    }

    public function getPermissionsOfGroup(Group $group, Request $request)
    {
        $permissions = $group->permissions()->paginate((int)($request->per_page ?? 15));

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
        $group->fill($request->validated()+['updated_at' => now()])->save();
        $permissions = $request->permission_list ?? [];
        $shared_permissions = array_intersect($old_permissions,$request->permission_list ?? []);
        $attached_permissions = array_diff($request->permission_list ?? [],$shared_permissions);
        $detached_permissions = array_diff($old_permissions,$shared_permissions);
        if ($attached_permissions || $detached_permissions) {
            $group->admins?->each(function ($admin) use($attached_permissions,$detached_permissions){
                if ($detached_permissions) {
                    $admin->permissions()->detach($detached_permissions);
                }
                $new_permissions = array_diff($attached_permissions,$admin->permission_list);
                if ($new_permissions) {
                    $admin->permissions()->attach($new_permissions);
                }
            });
        }
        if ($request->group_list) {
            $permissions = array_filter(array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray()));
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

    public function permissions()
    {
        $saved_permissions = $this->savedPermissions()->except('uri')->toArray();
        $saved_names = array_column($saved_permissions, 'named_uri');
        foreach (app()->routes->getRoutes() as $value) {
            $name = $value->getName();
            if (in_array($name, Permission::PUBLIC_ROUTES) || is_null($name) || in_array(str_before($name, '.'), ['ignition', 'debugbar']) || !str_contains($value->getPrefix(),'api')) {
                continue;
            }
            if (!in_array($name, $saved_names)) {
                $route = Permission::create(['name' => $name]);
                $saved_permissions[] = $this->getTransPermission($route);
            }
        }
        return UriResource::collection(array_except($saved_permissions, ['name', 'named_uri']))->additional(['status' => true, 'message' => '']);
    }


    private function savedPermissions()
    {
        return Permission::where('permission_on', 'dashboard_api')->select('id','name')->get()->transform(function($item){
            return $this->getTransPermission($item);
        });
    }

    public function getTransPermission($item)
    {
        $path = explode('.',$item->name);
        $single_uri = str_singular(@$path[0]);
        $action = trans('dashboard.' . $single_uri . '.permissions.' . @$path[1]);
        $item['id'] = $item->id;
        $item['uri'] = $path[0];
        $item['named_uri'] = $item->name;
        $item['name'] = trans('dashboard.' . $single_uri . '.' . $path[0]) . ' (' . $action . ')';
        $item['action'] = $action;
        return $item;
    }

    public function getGroups(Request $request,$group_id = null)
    {
        $groups = Group::when($group_id, function ($q) use ($group_id) {
            $q->where('groups.id', "<>", $group_id);
        })->when($request->activate_case, function ($q) use($request){
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
