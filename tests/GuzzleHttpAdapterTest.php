<?php

namespace seregazhuk\tests;

use Guzzle\Http\Message\RequestInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mockery;
use seregazhuk\SmsIntel\Api\GuzzleHttpClient;

class GuzzleHttpAdapterTest extends \PHPUnit_Framework_TestCase
{
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
