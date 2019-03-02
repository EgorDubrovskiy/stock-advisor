<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login() : JsonResponse
    {
        $credentials = array_merge(request(['email', 'password']), ['activation_token'  => null]);
        $ttl = request()->has('remember') ? config('jwt.rememberMeTokenExpireTime') : config('jwt.ttl');

        if (! $token = auth()->setTTL($ttl)->attempt($credentials)) {
            return response()->json(['error' => 'Incorrect email or password'], 401);
        }
        $this->response->data = ['Token' => $token, 'Message' => 'Authorized'];

        return new JsonResponse($this->response);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() : JsonResponse
    {
        $this->response->data = ['User' => auth()->user()];

        return new JsonResponse($this->response);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() : JsonResponse
    {
        auth()->logout();

        $this->response->data = ['Message' => 'Successfully logged out'];

        return new JsonResponse($this->response);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() : JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(string $token) : JsonResponse
    {
        return response()->json([
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }
}
