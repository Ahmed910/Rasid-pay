<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\Role\{RoleResource , UriResource};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Role\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::latest()->paginate((int)($request->page ?? 15));

        return RoleResource::collection($roles)->additional(['status' => true, 'message' => ""]);
    }


    public function create(Request $request)
    {
        $route=[];
        foreach (app()->routes->getRoutes() as $value) {
            // dump(Str::beforeLast($value->getName(),'.'));
            if(Str::afterLast($value->getPrefix(), '/') == "dashboard"){
                        if($value->getName() != 'dashboard.' && !is_null($value->getName())){
                            $uri =  Str::beforeLast($value->getName(),'.');
                            $route[]= ["uri" => $uri, 'trans' => trans('dashboard.' . Str::singular($uri) . ".{$uri}"), 'permissons' => trans('dashboard.' . Str::singular($uri) . ".permissions")];
                        }elseif (is_null($value->getName())) {
                            $route[]= ["uri" => "home", 'trans' => trans('dashboard.home.home') ,'permissons' => trans('dashboard.home.permissions')] ;

                        }
                    }
                }
        $public_routes = ['login' , 'post_login' , 'post_login' , 'seenNotify' , 'logout' , 'notification' , 'profile'];
        $uris = array_map("unserialize", array_unique(array_map("serialize", $route)));
        $routes = array_values($uris);
        return UriResource::collection($routes)->additional(['status' => true, 'message' => ""]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $route=[];
            foreach (app()->routes->getRoutes() as $value) {
                    $locale = app()->getLocale();
                    if($value->getPrefix() == $locale."/dashboard" || $value->getPrefix() == "/".$locale."/dashboard"){
                        if($value->getName() != 'dashboard.' && !is_null($value->getName())){
                            $route[]= str_before(str_after($value->getName(),'.'),'.') ;
                        }elseif (is_null($value->getName())) {
                            $route[]= 'home' ;

                        }
                    }
                   }

          $routes = array_values(array_unique($route));
          $public_routes = ['login' , 'post_login' , 'post_login' , 'seenNotify' , 'logout' , 'notification' , 'profile'];
          return view('dashboard.role.create',compact('routes','public_routes'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
