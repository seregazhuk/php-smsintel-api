<?php

namespace seregazhuk\tests;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Mockery;
use seregazhuk\SmsIntel\Api\GuzzleHttpClient;

class GuzzleHttpAdapterTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function it_sets_base_url_for_http_client()
    {
        $baseUrl = 'http://example.com';

        $http = Mockery::mock(ClientInterface::class)
            ->shouldReceive('setBaseUrl')
            ->with($baseUrl)
            ->getMock();

        $guzzleAdapter = new GuzzleHttpClient($http);
        $guzzleAdapter->setBaseUrl($baseUrl);
    }

    /** @test */
    public function it_executes_get_request_on_http_client()
    {
        $queryParams = ['key' => 'val'];
        $url = 'http://example.com';
        $uri = $url . '?' . http_build_query($queryParams);

        $http = Mockery::mock(ClientInterface::class)
            ->shouldReceive('get')
            ->with($uri)
            ->andReturn($this->createRequestMock())
            ->getMock();


        $guzzleAdapter = new GuzzleHttpClient($http);
        $guzzleAdapter->get($url, $queryParams);
    }

    /** @test */
    public function it_executes_post_request_on_http_client()
    {
        $url = 'http://example.com';
        $params = ['key' => 'val'];

        $http = Mockery::mock(ClientInterface::class)
            ->shouldReceive('post')
            ->with($url, [], $params)
            ->andReturn($this->createRequestMock())
            ->getMock();

        $guzzleAdapter = new GuzzleHttpClient($http);
        $guzzleAdapter->post($url, $params);
    }

    /**
     * @return Mockery\MockInterface
     */
    protected function createRequestMock()
    {
        $requestMock = Mockery::mock(RequestInterface::class)
            ->shouldReceive('send')
            ->andReturn(new Response(200))
            ->getMock();
        return $requestMock;
    }
}
