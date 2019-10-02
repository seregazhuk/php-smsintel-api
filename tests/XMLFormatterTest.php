<?php

namespace seregazhuk\tests;

use PHPUnit\Framework\TestCase;
use seregazhuk\SmsIntel\Formatters\XMLFormatter;

class XMLFormatterTest extends TestCase
{
    /** @test */
    public function it_formats_request_params_to_xml()
    {
        $params = ['key' => 'val'];

        $xml = (new XMLFormatter($params))->toXml();
        $this->assertXmlStringEqualsXmlString('<data><key>val</key></data>', $xml);
    }

    /** @test */
    public function it_creates_special_nodes_for_phone_numbers()
    {
        $params = [
            'key' => 'val',
            'to' => ['123456789']
        ];

        $xmlWithPhones = (new XMLFormatter($params))->toXml();
        $this->assertXmlStringEqualsXmlString(
            '<data><key>val</key><to number="123456789"></to></data>',
            $xmlWithPhones
        );
    }
}
