<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redirect;
use Closure;
use Session;

class CheckUserSession
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
		$menu_permission=Session::get('menu_permission');
        if($admin_id == NULL)
        {
            return Redirect::to('admin')->send();
        }else{
			if($menu_permission == 2){
				Session::put('message','Please change password');
				return Redirect::to('paward_change');
			}
			
		}
		return $next($request);
    }
}
