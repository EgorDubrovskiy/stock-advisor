<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use GuzzleHttp\Client;

class MessageController extends Controller
{
    public function healthCheck(): JsonResponse
    {
        $response = array(
            'message' => 'OK'
        );
        return new JsonResponse($response);
    }

    public function poll(): JsonResponse
    {
        $response = array(
            'message' => 'OK'
        );
        return new JsonResponse($response);
    }

    public function getNames(): JsonResponse
    {
        $client = new Client();
        $response = $client->request(
            'GET',
            config('iextrading.IEX_BASEPATH').'/ref-data/symbols?filter=symbol,name'
        );
        return new JsonResponse(json_decode($response->getBody()));
    }

    public function version(): JsonResponse
    {
        $response = array(
            'version' => app()::VERSION
        );
        return new JsonResponse($response);
    }
}
