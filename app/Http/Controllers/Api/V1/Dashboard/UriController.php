<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\RoleRequest;
use App\Http\Resources\Dashboard\MenuResource;
use App\Http\Resources\Dashboard\Role\{RoleResource , UriResource};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{Role\Role , Permission};
use App\Models\Menu\Menu;

class UriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menus = Menu::with('children')->parent()->oldest('order')->get();

        return MenuResource::collection($menus)->additional([
            'status' => true,
            'message' => "",
        ]);
    }

    public function store(MenuRequest $request,Menu $menu)
    {
        $menu->fill($request->validated())->save();

        return MenuResource::make($menu)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_add'),
        ]);
    }

    
    private function getPermissions($routes)
    {
        $permissions = @auth()->user()->role->permissions;
        $permission_arr = $permissions->map(function($item){
            $action = explode('.',$item->name);
            $data['uri'] = $action[0];
            $data['action'] = $action[1];
            return $data;
        })->groupBy('uri')->toArray();
        $uris = array_map(fn($item) => explode('.',$item)[0],$routes);
        $str_arr = ['read' , 'update' , 'archive'];
        $permitted_routes = [];
        $denied_routes = [];
        foreach(array_unique($uris) as $uri) {        
            $data = [];
            if(@$permission_arr[$uri] && in_array('store',array_column($permission_arr[$uri],'action'))){
                if (in_array($uri,array_column($permitted_routes,'uri'))) {
                    array_walk($permitted_routes, function (&$value, $key) use($uri){
                        if($value['uri'] == $uri){
                            $value['children'][]= ['uri' => 'store', 'trans' => trans('dashboard.'. str_singular($uri) . '.add_' . str_singular($uri))];
                        }
                    });
                }else{
                    $data['uri'] = $uri;
                    $data['children'][] = ['uri' => 'store', 'trans' => trans('dashboard.'. str_singular($uri) . '.add_' . str_singular($uri))];
                }
                $permitted_routes[] = $data;
            }
            $data = [];
            if (@$permission_arr[$uri] && array_intersect($str_arr,array_column($permission_arr[$uri],'action'))) {
                if(in_array($uri,array_column($permitted_routes,'uri'))){
                    array_walk($permitted_routes, function (&$value, $key) use($uri){
                        if($value['uri'] == $uri){
                            $value['children'][]= ['uri' => 'all', 'trans' => trans('dashboard.'. str_singular($uri) . '.' . $uri)];
                        }
                    });
                } else {
                    $data['uri'] = $uri;
                    $data['children'][] = ['uri' => 'all', 'trans' => trans('dashboard.'. str_singular($uri) . '.' . $uri)];
                }
                $permitted_routes[] = $data;
            }              
        }
        // $public_routes = []
        dd($permitted_routes , array_diff($routes,$permissions->pluck('name')->toArray()));

        // return ["uri" => $uri, 'trans' => trans('dashboard.' . Str::singular($uri) . ".{$uri}"), 'children' => $permissions];
    }

    private function setPermissions($routes)
    {
        $global_routes = ['profiles','notifications'];
        $uris = array_map(function($item) use($global_routes){
            $action = explode('.',$item);
            if(!in_array($action[0],$global_routes)){
                $data['uri'] = $action[0];
                $data['action'] = $action[1];
                $data['children'] = $item;
                return $data;
            }
        },$routes);

        $str_arr = ['read' , 'update' , 'archive'];
        foreach(array_values(array_unique(array_column($uris,'uri'))) as $index => $uri) {
            
            if(!Menu::firstWhere('uri' , $uri)){
                $menu = Menu::create([
                    'uri' => $uri,
                    'menu_type' => 'erp_dashboard',
                    'order' => $index,
                    'ar' => [
                        'name' => trans('dashboard.'. str_singular($uri) . '.' . $uri,[],'ar')
                    ],
                    'en' => [
                        'name' => trans('dashboard.'. str_singular($uri) . '.' . $uri,[],'en')
                    ]
                ]);
                $children = collect(array_where($uris,function($item) use($uri){
                    return @$item['uri'] == $uri;
                }));
                $children->transform(function($item,$key){            
                    return ['uri' => $item['children'],
                        'menu_type' => 'erp_dashboard',
                        'order' => 1,
                        'ar' => [
                            'name' => trans('dashboard.'. str_singular($item['uri']) . '.' . $item['action'],[],'ar')
                        ],
                        'en' => [
                            'name' => trans('dashboard.'. str_singular($item['uri']) . '.' . $item['action'],[],'ar')
                        ]
                    ];
                })->unique('uri');

                $menu->children()->createMany($children->toArray());
            }
        }       
    }
}
