<?php

namespace seregazhuk\SmsIntel\Api;

use GuzzleHttp\ClientInterface;

class GuzzleHttpClient
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
    public function get($uri, $params = [])
    {
        if (!empty($params)) {
            $uri .= '?' . http_build_query($params);
        }

        return (string)$this->client->get($uri)->getBody();
    }

    /**
     * @param string $uri
     * @param array $body
     * @return string
     */
    public function post($uri, $body = [])
    {
        return $this->client->post($uri, $body)->getBody();
    }
}
