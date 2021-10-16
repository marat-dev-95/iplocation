<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class ApiToken
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
        if(!$request->has('api_token')) {
            return response(['error'=>'forbidden'],Response::HTTP_FORBIDDEN);
        }
        if($request->api_token == Config::get('api.token')) {
            return $next($request);
        } else {
            return response(['error'=>'token has no permission'],Response::HTTP_UNAUTHORIZED);
        }
    }

}
