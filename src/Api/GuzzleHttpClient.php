<?php

namespace seregazhuk\SmsIntel\Api;

use GuzzleHttp\ClientInterface;
use seregazhuk\SmsIntel\Contracts\HttpClient;

class GuzzleHttpClient implements HttpClient
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $uri
     * @param array $params
     * @return string
     */
    public function get($uri, array $params = [])
    {
        return $this
            ->client
            ->request('GET', $uri, ['query' => $params])
            ->getBody();
    }

    /**
     * @param string $uri
     * @param array $body
     * @return string
     */
    public function post($uri, array $body = [])
    {
        return $this
            ->client
            ->request('POST', $uri, ['body' => json_encode($body)])
            ->getBody();
    }
}
