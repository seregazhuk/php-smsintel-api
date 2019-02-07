<?php

namespace seregazhuk\SmsIntel;

use GuzzleHttp\Client;
use seregazhuk\SmsIntel\Api\Requests\RequestsContainer;
use seregazhuk\SmsIntel\Exceptions\AuthenticationFailedException;

class SmsIntel
{
    /**
     * @param $login
     * @param $password
     * @return RequestsContainer
     * @throws AuthenticationFailedException
     */
    public static function create($login, $password)
    {
        self::checkCredentials($login, $password);

        return new RequestsContainer(
            new Client(),
            $login,
            $password
        );
    }

    /**
     * @param string $login
     * @param string $password
     * @throws AuthenticationFailedException
     */
    protected static function checkCredentials($login, $password)
    {
        if (empty($login) || empty($password)) {
            throw new AuthenticationFailedException('You must provide login and password to send messages!');
        }
    }

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * @codeCoverageIgnore
     */
    private function __clone()
    {
    }
}
