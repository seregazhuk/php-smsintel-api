<?php


namespace seregazhuk\SmsIntel;

use seregazhuk\SmsIntel\Adapters\GuzzleHttpAdapter;

class Sender {

	/**
	 * @var Request
	 */
	protected $request;

	public static function create($login, $password)
	{
		return new static($login, $password);
	}

	private function __construct($login, $password)
	{
		$this->request = new Request(new GuzzleHttpAdapter(), $login, $password);
	}

	public function send($to, $from, $message, $params = [])
	{

	}
}