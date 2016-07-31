<?php

namespace seregazhuk\SmsIntel\Contracts;

interface HttpInterface {

	/**
	 * @param $uri
	 * @param array $params
	 * @return array
	 */
	public function get($uri, $params = []);

	/**
	 * @param $uri
	 * @param $body
	 * @return array
	 */
	public function post($uri, $body);

	/**
	 * @param string $url
	 * @return $this
	 */
	public function setBaseUrl($url);
}