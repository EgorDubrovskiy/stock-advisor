<?php

namespace App\DomainServices;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Pool;

/**
 * Class ClientContainer
 * @package App\DomainServices
 */
class ClientContainer
{
    /** @var Client $client */
    public $client;

    /**
     * ClientContainer constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $url)
    {
        $response = $this->client->request('GET', $url);
        $result = json_decode($response->getBody()->getContents(), true);
        if (is_null($result)) {
            return $response->getBody()->getContents();
        }
        return $result;
    }

    /**
     * @param array $urls
     * @return array
     */
    public function batchGet(array $urls) : array
    {
        $requests = [];
        foreach ($urls as $url) {
            array_push($requests, new Request('GET', $url));
        }

        $responses = Pool::batch($this->client, $requests);
        $results = [];
        foreach ($responses as $response) {
            array_push($results, json_decode($response->getBody()->getContents()));
        }

        return $results;
    }
}
