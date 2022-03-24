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
        $group->fill($request->validated())->save();
        $permissions = $request->permission_list ?? [];
        if ($request->group_list) {
            $group->groups()->sync($request->group_list);
            $permissions = array_filter(array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray()));
        }
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
        return GroupResource::make($group)->additional(['status' => true, 'message' => trans('dashboard.general.success_delete')]);
    }

    private function getPermissions($uri, $group = null)
    {
        $flip_permissions = is_array(trans('dashboard.' . str_singular($uri) . '.permissions')) ? array_flip(trans('dashboard.' . Str::singular($uri) . '.permissions')) : [];
        $permissions = array_flip(substr_replace($flip_permissions, $uri . '.', 0, 0));
        $permissions_col = collect($permissions)->transform(function ($item, $key) use ($group) {
            $data['permission']  = $key;
            $data['trans']  = $item;
            $data['is_checked']  = isset($group) && @$group->permissions->contains('name', $key);
            return $data;
        })->values()->toArray();
        return ["uri" => $uri, 'trans' => trans('dashboard.' . Str::singular($uri) . ".{$uri}"), 'permissons' => $permissions_col];
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
                $saved_permissions[] = ['id' => $route->id, 'named_uri' => $name, 'name' => trans('dashboard.' . str_singular(str_before($name, '.')) . '.' . str_after($name, '.'))];
            }
        }
        return UriResource::collection(array_except($saved_permissions, ['name', 'named_uri']))->additional(['status' => true, 'message' => '']);
    }


    private function savedPermissions()
    {
        return Permission::where('permission_on', 'dashboard_api')->select('id','name')->get()->transform(function($item){
            $uri = str_before($item->name,'.');
            $single_uri = str_singular($uri);
            $action = trans('dashboard.' . $single_uri . '.permissions.' . str_after($item->name, '.'));
            $item['uri'] = $uri;
            $item['named_uri'] = $item->name;
            $item['name'] = trans('dashboard.' . $single_uri . '.' . $uri) . ' (' . $action . ')';
            $item['action'] = $action;
            return $item;
        });
    }

    public function getGroups($group_id = null)
    {
        $groups = Group::when($group_id, function ($q) use ($group_id) {
            $q->where('groups.id', "<>", $group_id);
        })->active()->with('permissions')->ListsTranslations('name')->without(['addedBy'])->get();

        return GroupResource::collection($groups)->additional(['status' => true, 'message' => ""]);
    }
}
