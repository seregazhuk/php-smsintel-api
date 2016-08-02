<?php

namespace seregazhuk\SmsIntel;

use seregazhuk\SmsIntel\Exceptions\AuthException;
use seregazhuk\SmsIntel\Contracts\RequestInterface;
use seregazhuk\SmsIntel\Adapters\GuzzleHttpAdapter;
use seregazhuk\SmsIntel\Requests\RequestsContainer;

class Sender
{
    /**
     * @var RequestInterface[]
     */
    protected $requests = [];

    /**
     * @param $login
     * @param $password
     * @return static
     */
    public static function create($login, $password)
    {
        self::checkCredentials($login, $password);

        return new static($login, $password);
    }

    /**
     * @param string $login
     * @param string $password
     * @throws AuthException
     */
    protected static function checkCredentials($login, $password)
    {
        if(empty($login) || empty($password)) {
            throw new AuthException('You must provide login and password to send messages!');
        }
    }

    /**
     * @param string $login
     * @param string $password
     */
    private function __construct(RequestsContainer $requestsContainer, $login, $password)
    {
        $this->requestsContainer = new Request(
            new GuzzleHttpAdapter(), $login, $password
        );
    }

    /**
     * @param string|array $to
     * @param string $from
     * @param string $message
     * @param array $params
     * @return array|null
     */
    public function send($to, $from, $message, $params = [])
    {
        $to = is_array($to) ? $to : [$to];

        $requestParams = array_merge(
            [
                'to'     => $to,
                'text'   => $message,
                'source' => $from,
            ], $params
        );

        return $this->request->exec('send', $requestParams);
    }
}