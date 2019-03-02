<?php

namespace App\Http\Middleware;

use App\Http\Response;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth as AuthFacade;

/**
 * Class Auth
 * @package App\Http\Middleware
 */
class Auth
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
        if (!AuthFacade::check()) {
            $response = new Response();
            $response->error['user'] = 'user is unauthorized';
            return new JsonResponse($response, JsonResponse::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
