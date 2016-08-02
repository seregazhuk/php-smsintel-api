<?php

namespace seregazhuk\SmsIntel\Requests;

use ReflectionClass;
use seregazhuk\SmsIntel\Contracts\HttpInterface;
use seregazhuk\SmsIntel\Contracts\RequestInterface;
use seregazhuk\SmsIntel\Exceptions\WrongRequestException;

class RequestsContainer
{
    const REQUESTS_NAMESPACE = 'seregazhuk\\SmsIntel\\Requests\\';

    /**
     * @var HttpInterface
     */
    private $http;

    public function __construct(HttpInterface $http)
    {
        $this->http = $http;
    }

    /**
     * @var RequestInterface[]
     */
    protected $requests = [];

    /**
     * Gets request object by name. If there is no such request
     * in requests array, it will try to create it, then save
     * it, and then return.
     *
     * @param string $request
     *
     * @throws WrongRequestException
     *
     * @return RequestInterface
     */
    public function getRequest($request)
    {
        $request = strtolower($request);
        // Check if an instance has already been initiated
        if (!isset($this->requests[$request])) {
            $this->addRequest($request);
        }
        return $this->requests[$request];
    }

    /**
     * Creates request by class name, and if success saves
     * it to requests array. Request class must be in REQUESTS_NAMESPACE.
     *
     * @param string $request
     *
     * @throws WrongRequestException
     */
    protected function addRequest($request)
    {
        $className = self::REQUESTS_NAMESPACE . ucfirst($request);
        if (!class_exists($className)) {
            throw new WrongRequestException("Request $className not found.");
        }
        $this->requests[$request] = $this->buildRequest($className);
    }

    /**
     * Build RequestInterface object with reflection API.
     *
     * @param string $className
     *
     *
     * @return object
     */
    protected function buildRequest($className)
    {
        return (new ReflectionClass($className))
            ->newInstanceArgs([$this->http]);
    }
}