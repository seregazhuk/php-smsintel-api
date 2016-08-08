<?php

namespace seregazhuk\tests\Requests;

use Mockery;
use seregazhuk\SmsIntel\Contracts\HttpInterface;
use seregazhuk\SmsIntel\Api\Requests\XMLRequest;
use seregazhuk\SmsIntel\Api\Requests\JSONRequest;
use seregazhuk\SmsIntel\Api\Requests\RequestsContainer;

class RequestsContainerTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_returns_an_instance_of_request_object()
    {
        $request = $this->createContainerObject()
            ->getRequest(XMLRequest::class);

        $this->assertInstanceOf(XMLRequest::class, $request);
    }

    /**
     * @test
     * @expectedException \seregazhuk\SmsIntel\Exceptions\WrongRequestException
     */
    public function it_throws_exception_when_getting_request_object_that_does_not_exist()
    {
        $this->createContainerObject()
            ->getRequest('NonExistingRequest');
    }

    /** @test */
    public function it_resolves_request_object_by_specified_action()
    {
        $request = $this->createContainerObject()
            ->resolveRequestByAction('send');

        $this->assertInstanceOf(JSONRequest::class, $request);
    }

    /**
     * @test
     * @expectedException \seregazhuk\SmsIntel\Exceptions\WrongRequestException
     */
    public function it_throws_exception_when_resolving_request_by_wrong_action()
    {
        $this->createContainerObject()
            ->resolveRequestByAction('badAction');
    }

    /**
     * @return RequestsContainer
     */
    protected function createContainerObject()
    {
        return new RequestsContainer(
            Mockery::mock(HttpInterface::class), 'login', 'password'
        );
    }

    protected function tearDown()
    {
        Mockery::close();
    }
}
