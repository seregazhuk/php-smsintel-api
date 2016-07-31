<?php


namespace seregazhuk\tests;


use seregazhuk\SmsIntel\CharsetManager;

class CharsetManagerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @test
	 */
	public function it_returns_charset_of_the_string()
	{
		$utf8String = 'test';
		$this->assertEquals('UTF-8', CharsetManager::detect($utf8String));
	}
}
