<?php

namespace App\Http\Middleware;

use Closure;

class AuthorMiddleware
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

        $access_token = $request->header('Authorization');

        if( ! $access_token ) {

            return redirect()->route('unautherized');
        }

        return $next($request); 
    }
}
