<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redirect;
use Closure;
use Session;

class CheckSession
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
		$admin_id=Session::get('admin_id');
		
        if($admin_id != NULL)
        {
            return Redirect::to('dashboard')->send();
        }
		return $next($request);
    }
}
