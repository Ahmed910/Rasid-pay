<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class AdminMiddleware 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $public_routes = [
            'dashboard.notification.index' ,
            'dashboard.notification.show' ,
            'dashboard.notification.delete' ,
            'dashboard.profile.show',
            'dashboard.profile.update',
            'dashboard.profile.change_password',
            'dashboard.menus.index',
            'dashboard.menus.store',
            'dashboard.menus.show',
            'dashboard.menus.destroy',
        ];
        if (auth()->check() && auth()->user()->user_type == 'superadmin')
        {
            return $next($request);
        }elseif (auth()->check() && auth()->user()->role()->exists() && auth()->user()->user_type == 'admin'){
            if (auth()->user()->hasPermissions(Str::beforeLast($request->route()->getName(),'.') , $request->route()->getActionMethod()) || in_array($request->route()->getName(),$public_routes)){
                return $next($request);
            }elseif (auth()->user()->hasPermissions(Str::beforeLast($request->route()->getName(),'.') , 'update') && ($request->route()->getActionMethod() == 'index' || $request->route()->getActionMethod() == 'edit')){
                return $next($request);
            }elseif (auth()->user()->hasPermissions(Str::beforeLast($request->route()->getName(),'.') , 'destroy') && ($request->route()->getActionMethod() == 'destroy' || $request->route()->getActionMethod() == 'index')){
                return $next($request);
            }elseif (auth()->user()->hasPermissions(Str::beforeLast($request->route()->getName(),'.') , 'index') && $request->route()->getActionMethod() == 'show'){
                return $next($request);
            }elseif (auth()->user()->hasPermissions(Str::beforeLast($request->route()->getName(),'.') , 'store') && $request->route()->getActionMethod() == 'create'){
                return $next($request);
            }elseif (auth()->user()->hasPermissions(Str::beforeLast($request->route()->getName(),'.') , 'archive') && $request->route()->getActionMethod() == 'archive'){
                return $next($request);
            }elseif ($request->is(app()->getLocale() . "/dashboard/search")){
                return $next($request);
            }else{
               return response()->json(['status' => false , 'message' => trans('dashboard.error.403_msg'), 'data' => null]);
            }
            return $next($request);
        }
        return response()->json(['status' => false , 'message' => trans('dashboard.messages.login_firstly'), 'data' => null]);
    }
}
