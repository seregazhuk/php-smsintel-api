<?php

namespace seregazhuk\SmsIntel\Requests;

use ReflectionClass;
use seregazhuk\SmsIntel\Contracts\HttpInterface;
use seregazhuk\SmsIntel\Contracts\RequestInterface;
use seregazhuk\SmsIntel\Exceptions\WrongRequestException;

class RequestsContainer
{
    protected function getRequestsActionsMap() {
        return [
            XMLRequest::class  => XMLRequest::getAllowedMethods(),
            JSONRequest::class => JSONRequest::getAllowedMethods(),
        ];
    }

    /**
     * @var HttpInterface
     */
    protected $http;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $password;

    public function __construct(HttpInterface $http, $login, $password)
    {
        $this->http = $http;
        $this->login = $login;
        $this->password = $password;
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
     * @param string $requestClass
     *
     * @throws WrongRequestException
     *
     * @return RequestInterface
     */
    public function getRequest($requestClass)
    {
        $requestClass = strtolower($requestClass);
        // Check if an instance has already been initiated
        if (!isset($this->requests[$requestClass])) {
            $this->addRequest($requestClass);
        }
        return $this->requests[$requestClass];
    }

    /**
     * @param $action
     * @return string
     * @throws WrongRequestException
     */
    public function resolveRequestByAction($action)
    {
        foreach ($this->getRequestsActionsMap() as $requestClass => $actions) {
            if(in_array($action, $actions)) {
                return $this->getRequest($requestClass);
            }
        }

        throw new WrongRequestException("Action $action doesn't exist!");
    }

    /**
     * Creates request by class name, and if success saves
     * it to requests array.
     *
     * @param string $requestClass
     *
     * @throws WrongRequestException
     */
    protected function addRequest($requestClass)
    {
        if (!class_exists($requestClass)) {
            throw new WrongRequestException("Request $requestClass not found.");
        }
        $this->requests[$requestClass] = $this->buildRequest($requestClass);
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
            ->newInstanceArgs([$this->http])
            ->setCredentials($this->login, $this->password);
    }
}