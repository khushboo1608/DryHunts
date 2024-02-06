<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // if (Auth::guard($guards)->check()) {
        //     switch (Auth::user()->login_type) {
        //         case '1':
        //             return redirect('admin/home');
        //         case '2':
        //             return redirect('home');
        //         case '3':
        //             return redirect('admin/home');
        //         case '4':
        //             return redirect('admin/home');
        //         default:
        //             auth()->logout();
        //             return route('/');
        //     }
        // } 

        // return $next($request);

        if($request->is('admin'))
        {
            if (Auth::guard('admin')->check()) {
                // print_r(Auth::user()->user_type);exit();
                switch (Auth::guard('admin')->user()->login_type) {
                    case '1':
                        return redirect('admin/home');
                    case '3':
                        return redirect('admin/order');
                    case '4':
                        return redirect('admin/order');
                    default:
                        auth()->logout();
                        return redirect('admin');
                        // return $next($request);
                }
            }
            auth()->logout();
            return $next($request);
        }
        else
        {
            // echo 'in';die;
            if (Auth::guard($guards)->check()) {
                // print_r($request->is('admin/*'));exit();
                // print_r(Auth::guard('admin')->user()->user_type);exit();
                switch (Auth::guard($guards)->user()->login_type) {
                    case '2':
                        return redirect('webhome');
                    // case '2':
                    //     return redirect('webhome');
                    // case '3':
                    //     return redirect('admin/home');
                    // case '4':
                    //     return redirect('admin/home');
                    default:
                    // return redirect('/');
                        auth()->logout();
                        return $next($request);
                }
            }
            return $next($request);
        }
    }
}
