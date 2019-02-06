<?php

namespace seregazhuk\SmsIntel\Api\Requests;

use ReflectionClass;
use seregazhuk\SmsIntel\Contracts\HttpClient;
use seregazhuk\SmsIntel\Exceptions\WrongRequest;

/**
 * @method send(string|array $phoneNumber, string $from, string $message) To send message to one or array of phone numbers
 * @method getGroups(int $groupId = null, string $groupName = null) Get all groups
 * @method createGroup(string $groupName) Create a new group of contacts
 * @method editGroup(string $newName, int $groupId) Edit group name by id
 * @method addContact(array $contactInfo) Create a new contact
 * @method getContacts(int $groupId = null, string $phone = null) Get all contacts
 * @method getPhoneInfo(string $phone) Get contact info by phone number
 * @method requestSource(string $from) Request a source name
 * @method removeContact(string $phone, int $groupId = null) Remove contact by phone number
 *
 * @method cancel(string $smsId) Cancel sms by id
 * @method getBalance() Get balance
 * @method checkCoupon(string $couponCode, bool $discountOnly) Use discount coupon
 * @method getReportBySms(int $smsId) Get report by smsId
 * @method getReportBySource($dateFrom, $dateTo, string $from) Get report for period by source
 * @method getReportByNumber($dateFrom, $dateTo, string $phone = null) Get report for period by phone number
 */
class RequestsContainer
{

    /**
     * @var HttpClient
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

    public function __construct(HttpClient $http, $login, $password)
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