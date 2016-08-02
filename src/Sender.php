<?php

namespace seregazhuk\SmsIntel;

use seregazhuk\SmsIntel\Requests\RequestsContainer;

class Sender
{
    /**
     * @var RequestsContainer
     */
    protected $requestsContainer;

    /**
     * @param RequestsContainer $requestsContainer
     */
    public function __construct(RequestsContainer $requestsContainer)
    {
        $this->requestsContainer = $requestsContainer;
    }

    /**
     * Proxies all methods to appropriate Request object
     *
     * @param string $method
     * @param array $arguments
     * @return array
     */
    function __call($method, $arguments)
    {
        $request = $this
            ->requestsContainer
            ->resolveRequestByAction($method);

        return $request->{$method}($arguments);
    }

}