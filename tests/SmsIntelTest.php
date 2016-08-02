<?php

namespace seregazhuk\tests;

use seregazhuk\SmsIntel\Sender;
use seregazhuk\SmsIntel\Factories\SmsIntel;

class SmsIntelTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_creates_an_instance_of_sender()
    {
        $this->assertInstanceOf(Sender::class, SmsIntel::create('login', 'password'));
    }
}
