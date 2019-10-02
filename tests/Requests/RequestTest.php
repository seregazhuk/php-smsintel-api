<?php

namespace seregazhuk\tests\Requests;

use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use seregazhuk\SmsIntel\Api\GuzzleHttpClient;
use seregazhuk\SmsIntel\Api\Requests\Request;
use seregazhuk\SmsIntel\Api\Requests\XMLRequest;
use seregazhuk\SmsIntel\Api\Requests\JSONRequest;

abstract class RequestTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /**
     * @var string
     */
    protected $requestClass;

    /**
     * @var GuzzleHttpClient|Mock
     */
    protected $httpClient;

    /**
     * Creates Request object mock and sets expectations for the httpClient mock.
     * @param string $action
     * @param array $requestParams
     * @return Request|XMLRequest|JSONRequest
     */
    protected function getRequestMock($action, $requestParams = []) {
        $this->createHttpClientMock();
        $requestParams = $this->appendCredentialsToRequestParams($requestParams);

        $request = $this->createRequestObject()
            ->setCredentials('test', 'test');

        $this->setHttpClientMockExpectations($action, $requestParams);

        return $request;
    }

    /**
     * Should return Request object.
     * @return Request
     */
    protected function createRequestObject() {
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
        $this->httpClient = Mockery::mock(GuzzleHttpClient::class);
    }
}
