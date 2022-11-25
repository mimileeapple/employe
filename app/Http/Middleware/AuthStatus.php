<?php

namespace App\Http\Middleware;
use Closure;
use Session;
class AuthStatus
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
        if(!Session::has('empid')){
            return  redirect()->route('logout');
        }else{
            return $next($request);
        }
    }
}
