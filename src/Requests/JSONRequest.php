<?php

namespace seregazhuk\SmsIntel\Requests;

class JSONRequest extends Request
{
    /**
     * @return array
     */
    public static function getAllowedMethods() {
        return [
            'getSource',
        ];
    }

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
    public function makeEndPoint($action)
    {
        return 'https://lcab.smsintel.ru/lcabApi/' . $action . '.php';
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