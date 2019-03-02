<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Class PingController
 * @package App\Http\Controllers
 */
class PingController extends Controller
{
    public function ping(): JsonResponse
    {
        return response()->json(['response' => 'pong']);
    }

}
