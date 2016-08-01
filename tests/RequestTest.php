<?php

namespace seregazhuk\tests;

use Mockery;
use seregazhuk\SmsIntel\Request;
use seregazhuk\SmsIntel\XMLFormatter;
use seregazhuk\SmsIntel\Contracts\HttpInterface;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function it_adds_credentials_to_request_body()
    {
        $requestParams =  [
            'login'    => 'mylogin',
            'password' => 'mypassword',
            'key'      => 'value',
        ];
        $requestXML = $this->createParamsXml($requestParams);

        $httpClient = Mockery::mock(HttpInterface::class);
        $httpClient
            ->shouldReceive('post')
            ->with(Request::BASE_URL . 'send.php', $requestXML);

        $request = new Request($httpClient, 'mylogin', 'mypassword');
        $request->exec('send', ['key' => 'value']);
    }

    /** @test */
    public function it_gets_api_endpoint_from_action()
    {
        $requestXML = $this->createParamsXml(['login' => 'test', 'password' => 'test']);
        $httpClient = Mockery::mock(HttpInterface::class);
        $httpClient
            ->shouldReceive('post')
            ->with(Request::BASE_URL . 'send.php', $requestXML);

        $request = new Request($httpClient, 'test', 'test');
        $request->exec('send', []);
    }

    protected function createParamsXml($params)
    {
        return (new XMLFormatter($params))->toXml();
    }
}
