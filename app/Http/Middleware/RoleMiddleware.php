<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class RoleMiddleware
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
        if(Auth::check())
        {
            if(auth()->user()->role == 1)
            {
                return $next($request);
            }
            else
            {
                return response()->json([
                    'success'=> false,
                    'message'=>'Access Denied.! As you are not an Admin.',
                ], 403);
            }
        }
        else
        {
            return response()->json([
                'success'=> false,
                'message'=>'Please Login First.',
            ],401);
        }
    }
}
