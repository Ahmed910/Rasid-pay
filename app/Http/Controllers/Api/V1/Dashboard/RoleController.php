<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\RoleRequest;
use App\Http\Resources\Dashboard\Role\{RoleResource , UriResource};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{Role\Role , Permission};

class RoleController extends Controller
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
        $roles = Role::search($request)->with(['translations' => function ($q) {
            $q->where('locale', app()->getLocale());
        }])->latest()->paginate((int)($request->page ?? 15));

        return RoleResource::collection($roles)->additional(['status' => true, 'message' => ""]);
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
                'role' => null,
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
    public function store(RoleRequest $request)
    {
        $permission_inputs =$request->validated()['permissions'];
        $role = Role::create(array_only($request->validated(),config('translatable.locales')));
        $permission_list = [];
        foreach ($permission_inputs as $permission) {
            $permission_obj= Permission::updateOrCreate(['name' => $permission['name']],$permission);
            $permission_list[] =$permission_obj->id;
        }
        $role->permissions()->sync($permission_list);

        return RoleResource::make($role)->additional(['status' => true, 'message' => trans('general.success_add')]);
    }

    public function show(Role $role)
    {
        $route=[];
        foreach (app()->routes->getRoutes() as $value) {
            if(Str::afterLast($value->getPrefix(), '/') == "dashboard"){
                if($value->getName() != '' && !is_null($value->getName())){
                    if (in_array($value->getName(),$this->public_routes)) {
                        continue;
                    }   
                    $uri =  Str::beforeLast($value->getName(),'.');
                    $route[] = $this->getPermissions($uri,$role);
                }
            }
        }
        $uris = array_map("unserialize", array_unique(array_map("serialize", $route)));
        $routes = array_values($uris);
        return response()->json([
            'status' => true,
            'message' => "",
            'data' => [
                'role' => RoleResource::make($role->load('translations')),
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
    public function update(RoleRequest $request, Role $role)
    {
        $permission_inputs =$request->validated()['permissions'];
        $role_inputs = array_only($request->validated(),config('translatable.locales'));
        $role->update($role_inputs);
        $permission_list = [];
        foreach ($permission_inputs as $permission) {
            $permission_obj= Permission::updateOrCreate(['name' => $permission['name']],$permission);
            $permission_list[] =$permission_obj->id;
        }
        $role->permissions()->sync($permission_list);
        return RoleResource::make($role)->additional(['status' => true, 'message' => trans('general.success_update')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return RoleResource::make($role)->additional(['status' => true, 'message' => trans('general.success_delete')]);
    }

    private function getPermissions($uri , $role = null)
    {
        $flip_permissions = is_array(trans('dashboard.'.Str::singular($uri).'.permissions')) ? array_flip(trans('dashboard.'.Str::singular($uri).'.permissions')) : [];
        $permissions = array_flip(substr_replace($flip_permissions, $uri . '.', 0, 0));
        $permissions_col = collect($permissions)->transform(function($item,$key) use($role){
             $data['permission']  = $key;
             $data['trans']  = $item;
             $data['is_checked']  = isset($role) && @$role->permissions->contains('name',$key);
             return $data;
        })->values()->toArray();
        return ["uri" => $uri, 'trans' => trans('dashboard.' . Str::singular($uri) . ".{$uri}"), 'permissons' => $permissions_col];
    }
}
