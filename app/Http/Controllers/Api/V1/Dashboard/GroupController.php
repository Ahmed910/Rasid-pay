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
        $groups = Group::search($request)->with(['translations' => function ($q) {
            $q->where('locale', app()->getLocale());
        }])->latest()->paginate((int)($request->page ?? 15));

        return GroupResource::collection($groups)->additional(['status' => true, 'message' => ""]);
    }


    public function create(Request $request)
    {
        $route=[];
        foreach (app()->routes->getRoutes() as $value) {
            if(Str::afterLast($value->getPrefix(), '/') == "dashboard"){
                if (in_array($value->getName(),$this->public_routes)) {
                    continue;
                }
                if($value->getName() != '' && !is_null($value->getName())){
                    $uri =  Str::beforeLast($value->getName(),'.');
                    $route[] = $this->getPermissions($uri);
                }
            }
        }

        $uris = array_map("unserialize", array_unique(array_map("serialize", $route)));
        $routes = array_values($uris);
        return response()->json([
            'status' => true,
            'message' => "",
            'data' => [
                'group' => null,
                'routes' => UriResource::collection($routes),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $permission_inputs =$request->validated()['permissions'];
        $group = Group::create(array_only($request->validated(),config('translatable.locales')));
        $permission_list = [];
        foreach ($permission_inputs as $permission) {
            $permission_obj= Permission::updateOrCreate(['name' => $permission['name']],$permission);
            $permission_list[] =$permission_obj->id;
        }
        $group->permissions()->sync($permission_list);

        return GroupResource::make($group)->additional(['status' => true, 'message' => trans('dashboard.general.success_add')]);
    }

    public function show(Group $group)
    {
        $route=[];
        foreach (app()->routes->getRoutes() as $value) {
            if(Str::afterLast($value->getPrefix(), '/') == "dashboard"){
                if($value->getName() != '' && !is_null($value->getName())){
                    if (in_array($value->getName(),$this->public_routes)) {
                        continue;
                    }
                    $uri =  Str::beforeLast($value->getName(),'.');
                    $route[] = $this->getPermissions($uri,$group);
                }
            }
        }
        $uris = array_map("unserialize", array_unique(array_map("serialize", $route)));
        $routes = array_values($uris);
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
        $group_inputs = array_only($request->validated(),config('translatable.locales'));
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
        $flip_permissions = is_array(trans('dashboard.'.Str::singular($uri).'.permissions')) ? array_flip(trans('dashboard.'.Str::singular($uri).'.permissions')) : [];
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
        $saved_permissions = Permission::select('id','name')->get()->transform(function($item){
            $item['trans'] = trans('dashboard.' . str_singular(str_before($item->name,'.')) . '.' . str_after($item->name,'.'));
            return $item;
        })->toArray();
        $saved_names = array_column($saved_permissions,'name');
        foreach (app()->routes->getRoutes() as $value) {
            $name = $value->getName();
            if (in_array($name,$this->public_routes) || is_null($name) || str_before($name,'.') == 'ignition') {
                continue;
            }
            if(!in_array($name,$saved_names)){
                $route = Permission::create(['name' => $name]);
                $saved_permissions[] = ['id' => $route->id,'name' => $name , 'trans' => trans('dashboard.' . str_singular(str_before($name,'.')) . '.' . str_after($name,'.'))];
            }
        }
        return UriResource::collection($saved_permissions)->additional(['status' => true, 'message' => '']);
    }
}
