<?php

namespace App\Http\Controllers\Api\Dashboard\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Model\Role\Role;

class RoleController extends Controller
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
                    if(Str::afterLast($value->getPrefix(), '\\') == "dashboard"){
                        if($value->getName() != 'dashboard.' && !is_null($value->getName())){
                            $route[]= str_before(str_after($value->getName(),'.'),'.') ;
                        }elseif (is_null($value->getName())) {
                            $route[]= 'home' ;

                        }
                    }
                   }

        $public_routes = ['login' , 'post_login' , 'post_login' , 'seenNotify' , 'logout' , 'notification' , 'profile'];
        $routes = array_except(array_values(array_unique($route)),$public_routes);

        return RoleResource::collection($routes)->additional(['status' => true, 'message' => ""]);
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
