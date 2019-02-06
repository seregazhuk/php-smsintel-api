<?php

namespace seregazhuk\SmsIntel;

use GuzzleHttp\Client;
use seregazhuk\SmsIntel\Api\GuzzleHttpClient;
use seregazhuk\SmsIntel\Contracts\HttpClient;
use seregazhuk\SmsIntel\Api\Requests\RequestsContainer;
use seregazhuk\SmsIntel\Exceptions\AuthenticationFailed;

class SmsIntel
{
    /**
     * @param $login
     * @param $password
     * @return RequestsContainer
     * @throws AuthenticationFailed
     */
    public static function create($login, $password)
    {
        self::checkCredentials($login, $password);

        return new RequestsContainer(
            self::createHttpAdapter(),
            $login,
            $password
        );
    }

    /**
     * @return HttpClient
     */
    protected static function createHttpAdapter()
    {
        return new GuzzleHttpClient(new Client());
    }

    /**
     * @param string $login
     * @param string $password
     * @throws AuthenticationFailed
     */
    protected static function checkCredentials($login, $password)
    {
        if (empty($login) || empty($password)) {
            throw new AuthenticationFailed('You must provide login and password to send messages!');
        }
    }

    /**
     * @codeCoverageIgnore
     */
    private function __construct(){}

    /**
     * @codeCoverageIgnore
     */
    private function __clone(){}
}
