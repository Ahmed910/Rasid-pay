<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use App\Models\Permission;

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
        if (auth()->check() && auth()->user()->user_type == 'superadmin'){
            return $next($request);
        }elseif (auth()->check() && auth()->user()->permissions()->exists() && auth()->user()->user_type == 'admin'){
            if (auth()->user()->hasPermissions(Str::after($request->route()->getName(),'.')) || in_array($request->route()->getName(),Permission::PUBLIC_ROUTES)){
                return $next($request);
            }else{
               return response()->json(['status' => false , 'message' => trans('dashboard.error.403_msg'), 'data' => null],403);
            }
        }
        return response()->json(['status' => false , 'message' => trans('dashboard.messages.login_firstly'), 'data' => null],401);
    }
}
