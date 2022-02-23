<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class ClientMiddleware
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
        if (auth('sanctum')->check() && in_array(auth('sanctum')->user()->user_type,['client']) && ! auth('sanctum')->user()->is_user_deactive) {
            return $next($request);
        }elseif (auth('sanctum')->check() &&  auth('sanctum')->user()->is_user_deactive) {
            return response()->json(['status' => 'fail','message'=> trans('api.auth.ur_account_banned'),'data' => null] ,403);
        }else{
            return response()->json(['status' => 'fail','message'=> trans('api.auth.login_data_not_true'),'data' => null] ,401);
        }
    }
}
