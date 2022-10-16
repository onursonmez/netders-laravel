<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Lang;

class SetupApplication
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
        if(!Session::get('city_slug'))
        {
            Session::put('city_slug', 'istanbul');
        }

        if(!Session::get('timezone'))
        {
            Session::put('timezone', Lang::get('general.default_timezone'));
        }        
        
        return $next($request);
    }
}
