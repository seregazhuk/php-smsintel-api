<?php

namespace seregazhuk\SmsIntel\Requests;

use seregazhuk\SmsIntel\Contracts\HttpInterface;
use seregazhuk\SmsIntel\Contracts\RequestInterface;

abstract class Request implements RequestInterface
{
    static public $allowedMethod = [];

    /**
     * @var HttpInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $password;

    public function __construct(HttpInterface $http)
    {
        $this->client = $http;
    }


    /**
     * @param string $login
     * @param string $password
     * @return $this
     */
    public function setCredentials($login, $password)
    {
        $this->login = $login;
        $this->password = $password;

        return $this;
    }

    /**
     * Make the request to API
     *
     * @param string $action
     * @param array $params
     * @return array|null
     */
    public function exec($action, $params = [])
    {
        $endPoint = $this->makeEndPoint($action);
        $requestBody = $this->createRequestBody($params);

        $response = $this->client->post($endPoint, $requestBody);
        return $this->parseResponse($response);
    }

    /**
     * @param array $params
     * @return string
     */
    protected function createRequestBody(array $params)
    {
        $params = array_merge(
            [
                'login'    => $this->login,
                'password' => $this->password,
            ],
            $params
        );

        return $this->formatRequestBody($params);
    }

    /**
     * @param array $requestBody
     * @return mixed
     */
    abstract protected function formatRequestBody(array $requestBody);

    /**
     * @param string $response
     * @return array
     */
    abstract protected function parseResponse($response);

    /**
     * @param string $action
     * @return string
     */
    abstract public function makeEndPoint($action);
}