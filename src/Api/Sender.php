<?php

namespace seregazhuk\SmsIntel\Api;

use seregazhuk\SmsIntel\Api\Requests\Request;
use seregazhuk\SmsIntel\Api\Requests\RequestsContainer;

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
     * Proxies all methods to the appropriate Request object
     *
     * @param string $method
     * @param array $arguments
     * @return array
     */
    public function __call($method, $arguments)
    {
        $request = $this
            ->requestsContainer
            ->resolveRequestByAction($method);

        return $this->callRequestMethod($request, $method, $arguments);
    }

    /**
     * Call a method of the request object according to the number of the
     * passed arguments
     *
     * @param Request $request
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    protected function callRequestMethod(Request $request, $method, array $arguments)
    {
        if(empty($arguments)) return $request->{$method}();

        switch (count($arguments)) {
            case 1:
                return $request->{$method}($arguments[0]);
            case 2:
                return $request->{$method}($arguments[0], $arguments[1]);
            case 3:
                return $request->{$method}($arguments[0], $arguments[1], $arguments[2]);
            case 4:
                return $request->{$method}($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
            case 5:
                return $request->{$method}($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4]);
            default:
                return $request->{$method}($arguments);
        }
    }
}
