<?php

namespace seregazhuk\SmsIntel;

use seregazhuk\SmsIntel\Contracts\HttpInterface;
use seregazhuk\SmsIntel\Contracts\RequestInterface;

class Request implements RequestInterface
{
    const BASE_URL = 'https://lcab.smsintel.ru/API/XML/';

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

    public function __construct(HttpInterface $http, $login = '', $password = '')
    {
        $this->client = $http;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * Make the request to API
     *
     * @param string $action
     * @param array $params
     * @return array|null
     */
    public function exec($action, $params = [ ])
    {
        $endPoint = $this->makeEndPoint($action);
        $requestBody = $this->createRequestBody($params);

        return $this->client->post($endPoint, $requestBody);
    }

    /**
     * @param string $action
     * @return string
     */
    protected function makeEndPoint($action)
    {
        return self::BASE_URL . $action . '.php';
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
            $params);

        return (new XMLFormatter($params))->toXml();
    }
}