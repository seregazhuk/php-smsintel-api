<?php

namespace seregazhuk\SmsIntel\Contracts;

interface RequestInterface {

    /**
     * Send the request to API
     * @param $uri
     * @param $params
     */
    public function exec($uri, $params);
}