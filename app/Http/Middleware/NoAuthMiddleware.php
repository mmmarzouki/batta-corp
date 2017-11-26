<?php

namespace App\Http\Middleware;

use Closure;

class NoAuthMiddleware
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

        if( $access_token ) {

            return redirect()->route('access_denied');
        }

        return $next($request);
    }
}
