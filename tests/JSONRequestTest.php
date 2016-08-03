<?php

namespace seregazhuk\tests;

use seregazhuk\SmsIntel\Requests\JSONRequest;

class JSONRequestTest extends RequestTest
{
    /** @test */
    public function it_sends_messages()
    {
        $to = 'phoneTo';
        $from = 'phoneFrom';
        $message = 'test message';

        $this->createRequestMock(
                'sendSms',
                [
                    'to'     => [$to],
                    'source' => $from,
                    'txt'    => $message,
                ]
            )->send($to, $from, $message);
    }

    /** @test */
    public function it_appends_additional_params_when_sending_messages()
    {
        $to = 'phoneTo';
        $from = 'phoneFrom';
        $message = 'test message';
        $params = ['param1' => 'value1'];

        $this->createRequestMock(
            'sendSms',
            [
                'to'     => [$to],
                'source' => $from,
                'txt'    => $message,
                'param1' => 'value1'
            ]
        )->send($to, $from, $message, $params);
    }

    /** @test */
    public function it_requests_a_source_name()
    {
        $source = 'FromPHP';
        $this->createRequestMock(
                'requestSource',
                ['source' => $source]
            )
            ->requestSource($source);
    }

    /** @test */
    public function it_returns_phone_info()
    {
        $phone = '123456778';
        $this->createRequestMock(
                'getPhoneInfo',
                ['phone' => $phone]
            )
            ->getPhoneInfo($phone);
    }

    /** @test */
    public function it_returns_contacts()
    {
        $this
            ->createRequestMock(
                'getContacts',
                ['idGroup'=>null, 'phone' => null]
            )
            ->getContacts();
    }

    /** @test */
    public function it_adds_contact()
    {
        $contactInfo = [
            'idGroup' => 1,
            'phone'   => 12345,
            'f'       => 'Second Name',
            'i'       => 'First Name',
            'o'       => 'Middle Name',
        ];
        $this->createRequestMock('addContact', $contactInfo)
            ->addContact($contactInfo);
    }

    /** @test */
    public function it_removes_contact()
    {
        $phone = 'testPhone';
        $this->createRequestMock(
            'removeContact',
            ['phone' => $phone, 'groupId' => null])
        ->removeContact($phone);
    }

    /** @test */
    public function it_returns_groups_info()
    {
        $this->createRequestMock(
                'getGroups',
                ['id' => null, 'name' => null]
            )
            ->getGroups();
    }

    /** @test */
    public function it_create_a_new_group()
    {
        $groupName = 'Group1';

        $this->createRequestMock(
               'saveGroup',
               ['id' => null, 'name' => $groupName]
            )
            ->createGroup($groupName);
    }

    /** @test */
    public function it_edits_group_name()
    {
        $groupId = 123;
        $groupName = 'Group1';

        $this->createRequestMock(
                'saveGroup',
                ['id' => $groupId, 'name' => $groupName]
            )
            ->editGroup($groupName, $groupId);
    }

    /** @test */
    public function it_returns_account_info()
    {
        $this->createRequestMock('info')
            ->getAccountInfo();
    }

    /**
     * @param string $action
     * @param array $requestParams
     * @return JSONRequest
     */
    protected function createRequestMock($action, $requestParams = [])
    {
        $httpClient = $this->getHttpMock();
        $requestParams = $this->appendCredentialsToRequestParams($requestParams);

        $request = (new JSONRequest($httpClient))
            ->setCredentials('test', 'test');

        $httpClient
            ->shouldReceive('post')
            ->with(
                $request->makeEndPoint($action),
                $requestParams
            )
            ->andReturn('');

        return $request;
    }
}
