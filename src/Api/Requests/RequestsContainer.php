<?php

namespace seregazhuk\SmsIntel\Api\Requests;

use GuzzleHttp\Client;
use ReflectionClass;
use seregazhuk\SmsIntel\Api\GuzzleHttpClient;
use seregazhuk\SmsIntel\Exceptions\WrongRequest;

/**
 * @method send(string|array $phoneNumber, string $from, string $message) To send message to one phone number
 * @method getGroups
 * @method editGroup
 * @method addContact
 * @method getContacts
 * @method createGroup
 * @method getPhoneInfo
 * @method requestSource
 * @method removeContact
 *
 * @method cancel(int $smsId) Cancel sms by id
 * @method getBalance
 * @method checkCoupon
 * @method getReportBySms
 * @method getReportBySource
 * @method getReportByNumber
 */
class RequestsContainer
{
    /**
     * @var Client
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

    /**
     * @var Request[]
     */
    protected $requests = [];

    public function __construct(GuzzleHttpClient $http, $login, $password)
    {
        $this->http = $http;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * @return array
     */
    protected function getRequestsActionsMap()
    {
        return [
            XMLRequest::class  => XMLRequest::$allowedMethods,
            JSONRequest::class => JSONRequest::$allowedMethods,
        ];
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
        $request = $this->resolveRequestByAction($method);

        return $request->$method(...$arguments);
    }

    /**
     * Gets request object by name. If there is no such request
     * in requests array, it will try to create it, then save
     * it, and then return.
     *
     * @param string $requestClass
     *
     * @throws WrongRequest
     *
     * @return Request
     */
    public function getRequest($requestClass)
    {
        // Check if an instance has already been initiated
        if (!isset($this->requests[$requestClass])) {
            $this->addRequest($requestClass);
        }
        return $this->requests[$requestClass];
    }

    /**
     * @param $action
     * @return string
     * @throws WrongRequest
     */
    public function resolveRequestByAction($action)
    {
        foreach ($this->getRequestsActionsMap() as $requestClass => $actions) {
            if(in_array($action, $actions)) {
                return $this->getRequest($requestClass);
            }
        }

        throw new WrongRequest("Action $action doesn't exist!");
    }

    /**
     * Creates request by class name, and if success saves
     * it to requests array.
     *
     * @param string $requestClass
     *
     * @throws WrongRequest
     */
    protected function addRequest($requestClass)
    {
        if (!class_exists($requestClass)) {
            throw new WrongRequest("Request $requestClass not found.");
        }
        $this->requests[$requestClass] = $this->buildRequest($requestClass);
    }

    /**
     * Build RequestInterface object with reflection API.
     *
     * @param string $className
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
