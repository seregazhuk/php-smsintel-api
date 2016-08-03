<?php

namespace seregazhuk\SmsIntel\Adapters;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use seregazhuk\SmsIntel\Contracts\HttpInterface;

class GuzzleHttpAdapter implements HttpInterface
{

    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param $uri
     * @param array $params
     * @return string
     */
    public function get($uri, $params = [])
    {
        if (!empty($params)) {
            $uri .= '?' . http_build_query($params);
        }
        return $this->client->get($uri)->send()->getBody(true);
    }

    /**
     * @param string $uri
     * @param array $body
     * @return string
     */
    public function post($uri, $body)
    {
        return $this->client->post($uri, [], $body)->send()->getBody(true);
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
