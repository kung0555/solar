<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class ChekAdmin
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
        // if($request->user != "admin"){
        //     return redirect('/login');
        // }
        // else{
        //     return $next($request);
        // }

        // return $next($request);

        if (Auth::user() &&  Auth::user()->is_admin == true) {
            return $next($request);
        } elseif (Auth::user() &&  Auth::user()->is_admin != true) {
            return redirect('user_home');
        }

        return redirect('login')->with('error', 'You have not admin access');
    }
}
