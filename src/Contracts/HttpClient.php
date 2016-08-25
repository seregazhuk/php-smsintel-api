<?php

namespace seregazhuk\SmsIntel\Contracts;

interface HttpClient
{
    /**
     * @param $uri
     * @param array $params
     * @return array
     */
    public function get($uri, $params = []);

    /**
     * @param string $uri
     * @param array $body
     * @return array
     */
    public function post($uri, $body = []);

    /**
     * @param string $url
     * @return $this
     */
    public function setBaseUrl($url);
}
