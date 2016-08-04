<?php

namespace seregazhuk\tests;

use Mockery;
use Guzzle\Http\ClientInterface;
use seregazhuk\SmsIntel\Adapters\GuzzleHttpAdapter;

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

        $guzzleAdapter = new GuzzleHttpAdapter($http);
        $guzzleAdapter->setBaseUrl($baseUrl);
    }
}
