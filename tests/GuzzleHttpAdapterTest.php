<?php

namespace seregazhuk\tests;

use Guzzle\Stream\StreamInterface;
use GuzzleHttp\ClientInterface;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use seregazhuk\SmsIntel\Api\GuzzleHttpClient;

class GuzzleHttpAdapterTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

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
            ->with($url, $params)
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
        /** @var Mock $mockContent */
        $mockContent = Mockery::mock(StreamInterface::class);
        $mockContent->shouldReceive('getContents')->andReturn('{}');

        /** @var Mock $mockResponse */
        $mockResponse = Mockery::mock(ResponseInterface::class);
        $mockResponse->shouldReceive('getBody')->andReturn($mockContent);

        return $mockResponse;
    }
}
