<?php

namespace seregazhuk\tests;

use Mockery;
use seregazhuk\SmsIntel\Contracts\HttpInterface;
use seregazhuk\SmsIntel\Request;
use seregazhuk\SmsIntel\XMLFormatter;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function it_adds_credentials_to_request_body()
    {
        $httpClient = Mockery::mock(HttpInterface::class);
        $httpClient
            ->shouldReceive('post')
            ->with(
                Request::BASE_URL . 'send.php',
                $this->createParamsXml([
                    'login'    => 'mylogin',
                    'password' => 'mypassword',
                    'key'      => 'value',
                ])
            );

        $request = new Request($httpClient, 'mylogin', 'mypassword');
        $request->exec('send', ['key' => 'value']);
    }

    /** @test */
    public function it_gets_api_endpoint_from_action()
    {
        $httpClient = Mockery::mock(HttpInterface::class);
        $httpClient
            ->shouldReceive('post')
            ->with(
                Request::BASE_URL . 'send.php',
                $this->createParamsXml(['login' => 'test', 'password' => 'test'])
            );

        $request = new Request($httpClient, 'test', 'test');
        $request->exec('send', []);
    }

    /**
     * @test
     * @expectedException \seregazhuk\SmsIntel\Exceptions\BadEndpointException
     */
    public function it_throws_exception_when_requesting_bad_action()
    {
        $httpClient = Mockery::mock(HttpInterface::class);

        $request = new Request($httpClient, 'test', 'test');
        $request->exec('unknown', []);
    }

    protected function createParamsXml($params)
    {
        return (new XMLFormatter($params))->toXml();
    }
}
