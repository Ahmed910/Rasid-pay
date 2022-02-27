<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\GroupRequest;
use App\Http\Resources\Dashboard\Group\{GroupResource , UriResource};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{Group\Group , Permission};

class GroupController extends Controller
{
    private $public_routes = [
        'notifications.index' ,
        'notifications.show' ,
        'notifications.destroy' ,
        'notifications.update' ,
        'profiles.show',
        'profiles.update',
        'profiles.change_password',
        'menus.index',
        'menus.store',
        'menus.update',
        'menus.show',
        'menus.destroy',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = Group::with(['translations' => function ($q) {
            $q->where('locale', app()->getLocale());
        }])->search($request)->latest()->paginate((int)($request->page ?? 15));

        return GroupResource::collection($groups)->additional(['status' => true, 'message' => ""]);
    }


    public function create(Request $request)
    {
        $saved_permissions = $this->savedPermissions()->groupBy('uri')->map(function($item,$key){
            $data['uri'] = $key;
            $data['trans'] = trans('dashboard.' . str_singular($key) . '.' . $key);
            $data['permissions'] = $item->transform(function($item){
                unset($item->uri);
                $item->is_checked = false;
                return $item;
            })->toArray();
            return $data;
        });
        return response()->json([
            'status' => true,
            'message' => "",
            'data' => [
                'group' => null,
                'routes' => UriResource::collection($saved_permissions),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request , Group $group)
    {
        $permission_inputs =$request->validated()['permission_list'];
        $group->fill($request->validated())->save();
        $group->permissions()->sync($request->permission_list);

        return GroupResource::make($group)->additional(['status' => true, 'message' => trans('dashboard.general.success_add')]);
    }

    public function show(Group $group)
    {
        $group_permissions = $group->permissions->pluck('id')->toArray();
        $saved_permissions = $this->savedPermissions()->groupBy('uri')->map(function($item,$key) use($group_permissions){
            $data['uri'] = $key;
            $data['trans'] = trans('dashboard.' . str_singular($key) . '.' . $key);
            $data['permissions'] = $item->transform(function($item) use($group_permissions){
                unset($item->uri);
                $item->is_checked = in_array($item->id , $group_permissions);
                return $item;
            })->toArray();
            return $data;
        });

        return response()->json([
            'status' => true,
            'message' => "",
            'data' => [
                'group' => GroupResource::make($group->load('translations')),
                'routes' => UriResource::collection($routes),
            ]
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
        $permission_inputs =$request->validated()['permissions'];
        $group_inputs = array_only($request->validated(),config('translatable.locales')+['is_active']);
        $group->update($group_inputs);
        $permission_list = [];
        foreach ($permission_inputs as $permission) {
            $permission_obj= Permission::updateOrCreate(['name' => $permission['name']],$permission);
            $permission_list[] =$permission_obj->id;
        }
        $group->permissions()->sync($permission_list);
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

    private function getPermissions($uri , $group = null)
    {
        $flip_permissions = is_array(trans('dashboard.'.str_singular($uri).'.permissions')) ? array_flip(trans('dashboard.'.Str::singular($uri).'.permissions')) : [];
        $permissions = array_flip(substr_replace($flip_permissions, $uri . '.', 0, 0));
        $permissions_col = collect($permissions)->transform(function($item,$key) use($group){
             $data['permission']  = $key;
             $data['trans']  = $item;
             $data['is_checked']  = isset($group) && @$group->permissions->contains('name',$key);
             return $data;
        })->values()->toArray();
        return ["uri" => $uri, 'trans' => trans('dashboard.' . Str::singular($uri) . ".{$uri}"), 'permissons' => $permissions_col];
    }

    public function permissions()
    {
        $saved_permissions = $this->savedPermissions()->except('uri')->toArray();
        $saved_names = array_column($saved_permissions,'name');
        foreach (app()->routes->getRoutes() as $value) {
            $name = $value->getName();
            if (in_array($name,$this->public_routes) || is_null($name) || in_array(str_before($name,'.'),['ignition','debugbar'])) {
                continue;
            }
            if(!in_array($name,$saved_names)){
                $route = Permission::create(['name' => $name]);
                $saved_permissions[] = ['id' => $route->id,'name' => $name , 'trans' => trans('dashboard.' . str_singular(str_before($name,'.')) . '.' . str_after($name,'.'))];
            }
        }
        return UriResource::collection($saved_permissions)->additional(['status' => true, 'message' => '']);
    }


    private function savedPermissions()
    {
        return Permission::select('id','name')->get()->transform(function($item){
            $uri = str_before($item->name,'.');
            $single_uri = str_singular($uri);
            $item['uri'] = $uri;
            $item['trans'] = trans('dashboard.' . $single_uri . '.permissions.' . str_after($item->name,'.')) . ' (' . trans('dashboard.' . $single_uri . '.' . $uri) . ')';
            return $item;
        });
    }


}
