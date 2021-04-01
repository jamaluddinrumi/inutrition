<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CachePolicy
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
        // return $next($request);
        $response = $next($request);
        return $response->header('Cache-Control', 'no-cache, public');
    }
}
