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
