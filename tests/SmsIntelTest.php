<?php

namespace seregazhuk\tests;

use seregazhuk\SmsIntel\SmsIntel;
use seregazhuk\SmsIntel\Api\Sender;

class SmsIntelTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_creates_an_instance_of_sender()
    {
        $this->assertInstanceOf(Sender::class, SmsIntel::create('login', 'password'));
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
