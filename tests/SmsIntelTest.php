<?php

namespace seregazhuk\tests;

use PHPUnit\Framework\TestCase;
use seregazhuk\SmsIntel\SmsIntel;
use seregazhuk\SmsIntel\Api\Requests\RequestsContainer;

class SmsIntelTest extends TestCase
{
    /** @test */
    public function it_creates_an_instance_of_requests_container()
    {
        $this->assertInstanceOf(RequestsContainer::class, SmsIntel::create('login', 'password'));
    }

    /**
     * @test
     * @expectedException \seregazhuk\SmsIntel\Exceptions\AuthenticationFailed
     */
    public function it_throws_exception_with_empty_credentials()
    {
        SmsIntel::create('', '');
    }
}
