<?php

namespace App\Http\Controllers;

use App\DomainServices\ClientContainer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Exception;

/**
 * Class PriceController
 * @package App\Http\Controllers
 */
class PriceController extends Controller
{
    /**
     * @param Request $request
     * @param ClientContainer $client
     * @return JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPrice(Request $request, ClientContainer $client): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'symbols' => 'required|regex:/^[a-z0-9,-]+$/i'
        ]);
        if ($validator->fails()) {
            $this->response->error = 'Invalid symbol';
            return new JsonResponse($this->response);
        }
        $symbols = $request->get('symbols');
        $companies = explode(',', $symbols);
        $prices = [];
        foreach ($companies as $company) {
            try {
                $price = $client->get(config('iextrading.IEX_BASEPATH') . '/stock/' . $company . '/price');
                $prices[$company] = $price;
            } catch (Exception $e) {
                $statusCode = $e->getCode();
                if ($statusCode === JsonResponse::HTTP_NOT_FOUND) {
                    $prices[$company] = 'Company not found';
                }
            }
        }
        $this->response->data = $prices;
        return new JsonResponse($this->response);
    }
}
