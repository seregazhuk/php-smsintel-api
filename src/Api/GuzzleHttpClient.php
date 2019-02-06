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
    public function get($uri, $params = [])
    {
        if (!empty($params)) {
            $uri .= '?' . http_build_query($params);
        }

        return $this
            ->client
            ->get($uri)
            ->send()
            ->getBody(true);
    }

    /**
     * @param string $uri
     * @param array $body
     * @return string
     */
    public function post($uri, $body = [])
    {
        return $this
            ->client
            ->post($uri, [], $body)
            ->send()
            ->getBody(true);
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setBaseUrl($url)
    {
        $this->client->setBaseUrl($url);

        return $this;
    }
}
