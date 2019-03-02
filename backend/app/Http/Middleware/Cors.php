<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        return $next($request)
            ->header('Access-Control-Allow-Origin', config("cors.allowedOrigins"))
            ->header('Access-Control-Expose-Headers', config("cors.exposedHeaders"))
            ->header('Access-Control-Max-Age', config("cors.maxAge"))
            ->header('Access-Control-Allow-Credentials', config("cors.allowCredentials"))
            ->header('Access-Control-Allow-Methods', config('cors.allowedMethods'))
            ->header('Access-Control-Allow-Headers', config('cors.allowedHeaders'))
            ->header('Access-Control-Allow-Credentials', config("cors.allowCredentials"));
    }
}
