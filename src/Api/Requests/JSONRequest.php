<?php

namespace seregazhuk\SmsIntel\Api\Requests;

class JSONRequest extends AbstractRequest
{
    /**
     * @var array
     */
    public static $allowedMethods = [
        'send',
        'getGroups',
        'editGroup',
        'addContact',
        'getContacts',
        'createGroup',
        'getPhoneInfo',
        'requestSource',
        'removeContact',
    ];

    /**
     * @param string|array $to
     * @param string $from
     * @param string $message
     * @param array $params
     * @return array|null
     */
    public function send($to, $from, $message, $params = [ ])
    {
        $to = is_array($to) ? $to : [ $to ];

        $requestParams = array_merge(
            [
                'to'     => $to,
                'txt'   => $message,
                'source' => $from,
            ],
            $params
        );

        return $this->exec('sendSms', $requestParams);
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function requestSource($name)
    {
        return $this->exec('requestSource', ['source' => $name]);
    }

    /**
     * @param null|string $groupId
     * @param null|string $phone
     * @return array|null
     */
    public function getContacts($groupId = null, $phone = null)
    {
        return $this->exec(
            'getContacts',
            ['idGroup' => $groupId, 'phone' => $phone]
        );
    }
    
    /**
     * @param string $phone
     * @return array|null
     */
    public function getPhoneInfo($phone)
    {
        return $this->exec('getPhoneInfo', ['phone' => $phone]);
    }

    /**
     * @param array $contactInfo
     * @return array|null
     */
    public function addContact(array $contactInfo)
    {
        return $this->exec('addContact', $contactInfo);
    }

    /**
     * @param string|null $groupId
     * @param string|null $groupName
     * @return array|null
     */
    public function getGroups($groupId = null, $groupName = null)
    {
        return $this->exec(
            'getGroups',
            ['id' => $groupId, 'name' => $groupName]
        );
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function createGroup($name)
    {
        return $this->editGroup($name, null);
    }

    /**
     * @param string $groupId
     * @param string $name
     * @return array|null
     */
    public function editGroup($name, $groupId)
    {
        return $this->exec('saveGroup', ['id' => $groupId, 'name' => $name]);
    }

    /**
     * @return array|null
     */
    public function getAccountInfo()
    {
        return $this->exec('info');
    }

    /**
     * @param string $phone
     * @param string|null $groupId
     * @return array|null
     */
    public function removeContact($phone, $groupId = null)
    {
        return $this->exec('removeContact', ['phone' => $phone, 'groupId' => $groupId]);
    }

    /**
     * @param string $action
     * @return string
     */
    protected function makeEndPoint($action)
    {
        return "https://lcab.smsintel.ru/lcabApi/{$action}.php";
    }

    /**
     * @param array $requestBody
     * @return string
     */
    protected function formatRequestBody(array $requestBody)
    {
        return \GuzzleHttp\json_encode($requestBody);
    }

    /**
     * @param string $response
     * @return array
     */
    protected function parseResponse($response)
    {
        return json_decode($response, true);
    }
}
