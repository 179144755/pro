<?php

namespace App\Http\Middleware;

use Closure;

class WebLogin
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
//        if(!session('web_user')){
//            throw new \Exception('请登陆');
//        }
        
        
        
        return $next($request);
    }
}
