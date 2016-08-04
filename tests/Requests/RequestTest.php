<?php

namespace seregazhuk\tests\Requests;

use Mockery;
use seregazhuk\SmsIntel\Requests\Request;
use seregazhuk\SmsIntel\Contracts\HttpInterface;

abstract class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $action
     * @param array $requestParams
     * @return Request
     */
    abstract protected function createRequestMock($action, $requestParams = []);

    protected function getHttpMock()
    {
        return Mockery::mock(HttpInterface::class);
    }

    /**
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
}
