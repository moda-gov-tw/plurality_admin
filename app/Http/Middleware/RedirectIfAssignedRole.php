<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectIfAssignedRole
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

    	//echo "<pre>";print_r();echo "</pre>";exit;

    	if(!isset(Auth::user()->roles->pluck('name')[0])){
    		
    		return redirect()->route('login');
    	}
    	

        return $next($request);
    }
}
