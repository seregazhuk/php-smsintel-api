<?php

namespace seregazhuk\SmsIntel\Contracts;

interface HttpClient
{
    /**
     * @param $uri
     * @param array $params
     * @return array
     */
    public function get($uri, array $params = []);

    /**
     * @param string $uri
     * @param array $body
     * @return array
     */
    public function post($uri, array $body = []);
}
