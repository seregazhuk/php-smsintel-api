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
     * @param string $method
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function exec($action, $params = [], $method = 'GET')
    {
        $endPoint = $this->makeEndPoint($action);
        $requestBody = $this->createRequestBody($params);

        $options = $this->makeOptions($method, $requestBody);

        $response = $this->guzzle->request($method, $endPoint, $options);

        return $this->parseResponse($response->getBody()->getContents());
    }

    /**
     * @param array $params
     * @return string|array
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
     * @param string $method
     * @param string|array $requestBody
     * @return array
     */
    private function makeOptions($method, $requestBody)
    {
        switch (strtoupper($method)) {
            case 'GET':
                return ['query' => $requestBody];
            case 'POST':
                $body = is_array($requestBody) ? \GuzzleHttp\json_encode($requestBody) : $requestBody;
                return ['body' => $body];

        }
    }

    /**
     * @param array $requestBody
     * @return string|array
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
