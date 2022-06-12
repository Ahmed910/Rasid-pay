<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckWalletBin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() && !auth()->user()->citizenWallet?->wallet_bin)
        {
           return response()->json([
               'status' => false,
               'data' => null,
               'message' => trans('mobile.messages.firstly_add_wallet_bin')
           ],412);
        }
        return $next($request);
    }
}
