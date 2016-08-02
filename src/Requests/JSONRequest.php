<?php

namespace seregazhuk\SmsIntel\Requests;

class JSONRequest extends Request
{
    const BASE_URL = 'https://lcab.smsintel.ru/lcabApi/';

    /**
     * @param string $source
     * @return array|null
     */
    public function getSource($source)
    {
        return $this->exec('requestSource', ['source' => $source]);
    }

    /**
     * @param string $action
     * @return string
     */
    protected function makeEndPoint($action)
    {
        return self::BASE_URL . $action . '.php';
    }

    /**
     * @param array $requestBody
     * @return mixed
     */
    protected function formatRequestBody(array $requestBody)
    {
        return $requestBody;
    }

    /**
     * @param string $response
     * @return array
     */
    protected function parseResponse($response)
    {
        return json_decode($response, true);
    }
}