<?php

namespace seregazhuk\SmsIntel\Api\Requests;

use GuzzleHttp\ClientInterface;

abstract class AbstractRequest
{
    /**
     * @var array
     */
    public static $allowedMethod = [];

    /**
     * @var ClientInterface
     */
    protected $guzzle;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $password;

    public function __construct(ClientInterface $client)
    {
        $this->guzzle = $client;
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

        $response = $this->guzzle->request('POST', $endPoint, ['body' => $requestBody]);
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

        ksort($params);

        return $this->formatRequestBody($params);
    }

    /**
     * @param array $requestBody
     * @return string
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
    abstract protected function makeEndPoint($action);
}
