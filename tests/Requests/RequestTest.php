<?php

namespace seregazhuk\tests\Requests;

use GuzzleHttp\ClientInterface;
use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use seregazhuk\SmsIntel\Api\Requests\AbstractRequest;
use seregazhuk\SmsIntel\Api\Requests\XMLRequest;
use seregazhuk\SmsIntel\Api\Requests\JSONRequest;

abstract class RequestTest extends TestCase
{
    /**
     * @var string
     */
    protected $requestClass;

    /**
     * @var ClientInterface|Mock
     */
    protected $httpClient;

    /**
     * Creates Request object mock and sets expectations for the httpClient mock.
     * @param string $action
     * @param array $requestParams
     * @return AbstractRequest|XMLRequest|JSONRequest
     */
    protected function getRequestMock($action, $requestParams = [])
    {
        $this->createHttpClientMock();
        $requestParams = $this->appendCredentialsToRequestParams($requestParams);

        $request = $this->createRequestObject()
            ->setCredentials('test', 'test');

        ksort($requestParams);
        $this->setHttpClientMockExpectations($action, $requestParams);

        return $request;
    }

    /**
     * Should return Request object.
     * @return AbstractRequest
     */
    protected function createRequestObject()
    {
        $requestClass = $this->getRequestClass();

        return new $requestClass($this->httpClient);
    }

    /**
     * Adds login and password fields to the request params
     *
     * @param array $requestParams
     * @return array
     */
    protected function appendCredentialsToRequestParams($requestParams)
    {
        return array_merge(
            ['login' => 'test', 'password' => 'test'],
            $requestParams
        );
    }

    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * @param string $requestEndpoint
     * @param array $requestParams
     * @return
     */
    abstract protected function setHttpClientMockExpectations($requestEndpoint, $requestParams);

    /**
     * @return string
     */
    protected function getRequestClass()
    {
        return property_exists($this, 'requestClass') ? $this->requestClass : '';
    }

    protected function createHttpClientMock()
    {
        $this->httpClient = Mockery::mock(ClientInterface::class);
    }
}
