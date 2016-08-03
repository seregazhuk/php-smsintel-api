<?php

namespace seregazhuk\tests;

use seregazhuk\SmsIntel\Requests\JSONRequest;

class JSONRequestTest extends RequestTest
{
    /** @test */
    public function it_sends_messages()
    {
        $to = 'phoneTo';
        $from = 'phoneFrom';
        $message = 'test message';

        $this->createRequestMock(
                'sendSms',
                [
                    'to'     => [$to],
                    'source' => $from,
                    'txt'    => $message,
                ]
            )->send($to, $from, $message);
    }

    /** @test */
    public function it_appends_additional_params_when_sending_messages()
    {
        $to = 'phoneTo';
        $from = 'phoneFrom';
        $message = 'test message';
        $params = ['param1' => 'value1'];

        $this->createRequestMock(
            'sendSms',
            [
                'to'     => [$to],
                'source' => $from,
                'txt'    => $message,
                'param1' => 'value1'
            ]
        )->send($to, $from, $message, $params);
    }

    /** @test */
    public function it_requests_a_source_name()
    {
        $source = 'FromPHP';
        $this->createRequestMock(
                'requestSource',
                ['source' => $source]
            )
            ->requestSource($source);
    }

    /** @test */
    public function it_returns_phone_info()
    {
        $phone = '123456778';
        $this->createRequestMock(
                'getPhoneInfo',
                ['phone' => $phone]
            )
            ->getPhoneInfo($phone);
    }

    /** @test */
    public function it_returns_contacts()
    {
        $this
            ->createRequestMock(
                'getContacts',
                ['idGroup'=>null, 'phone' => null]
            )
            ->getContacts();
    }

    /**
     * @param string $action
     * @param array $requestParams
     * @return JSONRequest
     */
    protected function createRequestMock($action, $requestParams = [])
    {
        $httpClient = $this->getHttpMock();
        $requestParams = $this->appendCredentialsToRequestParams($requestParams);

        $request = (new JSONRequest($httpClient))
            ->setCredentials('test', 'test');

        $httpClient
            ->shouldReceive('post')
            ->with(
                $request->makeEndPoint($action),
                $requestParams
            )
            ->andReturn('');

        return $request;
    }
}
