<?php

namespace seregazhuk\SmsIntel\Factories;

use Guzzle\Http\Client;
use seregazhuk\SmsIntel\Sender;
use seregazhuk\SmsIntel\Contracts\HttpInterface;
use seregazhuk\SmsIntel\Exceptions\AuthException;
use seregazhuk\SmsIntel\Requests\RequestsContainer;
use seregazhuk\SmsIntel\Adapters\GuzzleHttpAdapter;

class SmsIntel
{
    /**
     * @param $login
     * @param $password
     * @return Sender
     * @throws AuthException
     */
    public static function create($login, $password)
    {
        self::checkCredentials($login, $password);

        $requestsContainer = new RequestsContainer(
            self::createHttpAdapter(),
            $login,
            $password
        );
        return new Sender($requestsContainer);
    }

    /**
     * @return HttpInterface
     */
    protected static function createHttpAdapter()
    {
        return new GuzzleHttpAdapter(new Client());
    }

    /**
     * @param string $login
     * @param string $password
     * @throws AuthException
     */
    protected static function checkCredentials($login, $password)
    {
        if (empty($login) || empty($password)) {
            throw new AuthException('You must provide login and password to send messages!');
        }
    }

    private function __construct(){}
    private function __clone(){}
}
