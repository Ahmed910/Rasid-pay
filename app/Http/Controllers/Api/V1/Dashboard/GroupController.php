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
        $groups = Group::with('permissions')->withTranslation()->translatedIn(app()->getLocale())->search($request)->latest()->paginate((int)($request->per_page ?? 15));

        return GroupResource::collection($groups)->additional(['status' => true, 'message' => ""]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request , Group $group)
    {
        $group->fill($request->validated() + ['added_by_id' => auth()->id()])->save();
        $group->permissions()->sync($request->permission_list);
        return GroupResource::make($group)->additional(['status' => true, 'message' => trans('dashboard.general.success_add')]);
    }

    public function show(Group $group)
    {
        $group->load('translations','activity',['permissions' => function($q) use($group){
            $q->whereNotIn('permissions.id',$group->pluck('permissions')->pluck('id')->toArray());
        }]);

        return GroupResource::make($group)->additional(['status' => true, 'message' => '']);
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
        $group->update(array_only($request->validated(),config('translatable.locales')+['is_active']));
        $group->permissions()->sync($request->permission_list);
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
        $saved_names = array_column($saved_permissions,'named_uri');
        foreach (app()->routes->getRoutes() as $value) {
            $name = $value->getName();
            if (in_array($name,Permission::PUBLIC_ROUTES) || is_null($name) || in_array(str_before($name,'.'),['ignition','debugbar'])) {
                continue;
            }
            if(!in_array($name,$saved_names)){
                $route = Permission::create(['name' => $name]);
                $saved_permissions[] = ['id' => $route->id,'named_uri' => $name , 'name' => trans('dashboard.' . str_singular(str_before($name,'.')) . '.' . str_after($name,'.'))];
            }
        }
        return UriResource::collection(array_except($saved_permissions,['name', 'named_uri']))->additional(['status' => true, 'message' => '']);
    }


    private function savedPermissions()
    {
        return Permission::select('id','name')->get()->transform(function($item){
            $uri = str_before($item->name,'.');
            $single_uri = str_singular($uri);
            $action = trans('dashboard.' . $single_uri . '.permissions.' . str_after($item->name,'.'));
            $item['uri'] = $uri;
            $item['named_uri'] = $item->name;
            $item['name'] = trans('dashboard.' . $single_uri . '.' . $uri) . ' (' . $action . ')';
            $item['action'] = $action;
            return $item;
        });
    }


}
