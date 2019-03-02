<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use App\DomainServices\ClientContainer;
use GuzzleHttp\Client;

/**
 * Class ClientContainerTest
 * @package Tests\Unit
 */
class ClientContainerTest extends TestCase
{
    public function testOnReturnArray()
    {
        $mock = Mockery::mock(Client::class);
        $clientContainer = new ClientContainer($mock);
        $url = config('iextrading.IEX_BASEPATH').'stock/AAPL/company';

        $mockResponse = Mockery::mock(Response::class);
        $mock
            ->shouldReceive('request')
            ->once()
            ->with('GET', $url)
            ->andReturn($mockResponse);

        $mockStream = Mockery::mock(Stream::class);
        $mockResponse
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($mockStream);

        $jsonCompanyInfo = '{"symbol":"AAPL"}';
        $mockStream
            ->shouldReceive('getContents')
            ->once()
            ->withNoArgs()
            ->andReturn($jsonCompanyInfo);

        $this->assertEquals($clientContainer->get($url), json_decode($jsonCompanyInfo, true));
    }

    public function testOnReturnFloat()
    {
        $mock = Mockery::mock(Client::class);
        $clientContainer = new ClientContainer($mock);
        $url = config('iextrading.IEX_BASEPATH').'stock/AAPL/price';

        $mockResponse = Mockery::mock(Response::class);
        $mock
            ->shouldReceive('request')
            ->once()
            ->with('GET', $url)
            ->andReturn($mockResponse);

        $mockStream = Mockery::mock(Stream::class);
        $mockResponse
            ->shouldReceive('getBody')
            ->twice()
            ->withNoArgs()
            ->andReturn($mockStream);

        $companyPrice = 'some price';
        $mockStream
            ->shouldReceive('getContents')
            ->twice()
            ->withNoArgs()
            ->andReturn($companyPrice);

        $this->assertEquals($clientContainer->get($url), $companyPrice);
    }
}
