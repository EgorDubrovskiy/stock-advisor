<?php

namespace App\Services\Models;

use App\DomainServices\ClientContainer;
use App\Models\Company;
use GuzzleHttp\Pool;
use App\Services\Models\Interfaces\PriceUpdateInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class PriceUpdateService
 * @package App\Services\Models
 */
class PriceUpdateService implements PriceUpdateInterface
{
    /**
     * @var $clientContainer
     */
    protected $clientContainer;

    /**
     * PriceUpdateService constructor.
     * @param ClientContainer $clientContainer
     */
    public function __construct(ClientContainer $clientContainer)
    {
        $this->clientContainer = $clientContainer;
    }

    /**
     * @return mixed
     */
    public function getPricesOfCompanies()
    {
        $companies = Company::orderBy('id', 'desc')->select('symbol', 'name')->take(10)->get();
        $requests = [];
        foreach ($companies as $company) {
            $requests[] = new Request(
                'GET', config('iextrading.IEX_BASEPATH') . '/stock/' . $company->symbol . '/price'
            );
        }
        Pool::batch($this->clientContainer->client, $requests, [
            'fulfilled' => function ($response, $index) use ($companies) {
                $companies[$index]['price'] = $response->getBody()->getContents();
            }
        ]);

        return $companies;
    }
}
