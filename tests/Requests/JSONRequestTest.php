<?php

namespace seregazhuk\tests\Requests;

use seregazhuk\SmsIntel\Requests\JSONRequest;

class JSONRequestTest extends RequestTest
{
    protected $requestClass = JSONRequest::class;

    /** @test */
    public function it_sends_messages()
    {
        $to = 'phoneTo';
        $from = 'phoneFrom';
        $message = 'test message';

        $this->getRequestMock(
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

        $this->getRequestMock(
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
        $this->getRequestMock(
                'requestSource',
                ['source' => $source]
            )
            ->requestSource($source);
    }

    /** @test */
    public function it_returns_phone_info()
    {
        $phone = '123456778';
        $this->getRequestMock(
                'getPhoneInfo',
                ['phone' => $phone]
            )
            ->getPhoneInfo($phone);
    }

    /** @test */
    public function it_returns_contacts()
    {
        $this
            ->getRequestMock(
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
        $this->getRequestMock('addContact', $contactInfo)
            ->addContact($contactInfo);
    }

    /** @test */
    public function it_removes_contact()
    {
        $phone = 'testPhone';
        $this->getRequestMock(
            'removeContact',
            ['phone' => $phone, 'groupId' => null])
        ->removeContact($phone);
    }

    /** @test */
    public function it_returns_groups_info()
    {
        $this->getRequestMock(
                'getGroups',
                ['id' => null, 'name' => null]
            )
            ->getGroups();
    }

    /** @test */
    public function it_create_a_new_group()
    {
        $groupName = 'Group1';

        $this->getRequestMock(
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

        $this->getRequestMock(
                'saveGroup',
                ['id' => $groupId, 'name' => $groupName]
            )
            ->editGroup($groupName, $groupId);
    }

    /** @test */
    public function it_returns_account_info()
    {
        $this->getRequestMock('info')
            ->getAccountInfo();
    }

    /**
     * @param string $requestEndpoint
     * @param array $requestParams
     */
    protected function setHttpClientMockExpectations($requestEndpoint, $requestParams)
    {
        $this
            ->httpClient
            ->shouldReceive('post')
            ->with(
                $requestEndpoint,
                $requestParams
            )->andReturn('');
    }
}
