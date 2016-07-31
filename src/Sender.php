<?php

namespace seregazhuk\SmsIntel;

use seregazhuk\SmsIntel\Adapters\GuzzleHttpAdapter;

class Sender
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param $login
     * @param $password
     * @return static
     */
    public static function create($login, $password)
    {
        return new static($login, $password);
    }

    /**
     * @param string $login
     * @param string $password
     */
    private function __construct($login, $password)
    {
        $this->request = new Request(
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