<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\RoleRequest;
use App\Http\Resources\Dashboard\Role\{RoleResource , UriResource};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{Role\Role , Permission};

class UriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $route=[];
        foreach (app()->routes->getRoutes() as $value) {
            if(Str::afterLast($value->getPrefix(), '/') == "dashboard"){
                if($value->getName() != 'dashboard.' && !is_null($value->getName())){
                    $uri =  Str::beforeLast($value->getName(),'.');
                    $route[] = $this->getPermissions($uri);
                }elseif (is_null($value->getName())) {
                    if(auth()->user()->hasPermissions('home' ,'read')){
                        $route[]= ["uri" => "home", 'trans' => trans('dashboard.home.home'),'icon' => '','children' => []];
                    }
                }
            }
        }
        $uris = array_map("unserialize", array_unique(array_map("serialize", $route)));
        $routes = array_values($uris);
        dd($routes);
        // return response()->json([
        //     'status' => true, 
        //     'message' => "",
        //     'data' => [
        //         'role' => null,
        //         'routes' => UriResource::collection($routes),
        //     ]
        // ]);
    }

    
    private function getPermissions($uri , $role = null)
    {
        $permissions = @auth()->user()->role->permissions;
        dd($permissions);
        return ["uri" => $uri, 'trans' => trans('dashboard.' . Str::singular($uri) . ".{$uri}"), 'children' => $permissions_col];
    }
}
