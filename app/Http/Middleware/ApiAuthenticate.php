<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        print_r(Auth::guard('api')->check());exit();
        // echo 'in apu';die;
        $token = $request->bearerToken();
        print_r($token);exit();
        return $next($request);
    }
}
