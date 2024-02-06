<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
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
        // echo '<pre>';
        // print_r(auth()->user()); die;
        if(auth()->user())
        {
            // echo 'if'; die;
            if(auth()->user()->login_type == 1){
                return $next($request);
            }
            elseif(auth()->user()->login_type == 3){
                return $next($request);
            }
            elseif(auth()->user()->login_type == 4){
                return $next($request);
            }
            return redirect('admin/home')->with('error',"You don't have admin access.");
        }
        // echo 'else'; die;
        return redirect('admin')->with('error',"You don't have admin access.");
    }
}
