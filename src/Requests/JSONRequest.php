<?php

namespace seregazhuk\SmsIntel\Requests;

use seregazhuk\SmsIntel\XMLFormatter;

class JSONRequest extends Request
{
    const BASE_URL = 'https://lcab.smsintel.ru/lcabApi/';

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
        return (new XMLFormatter($requestBody))->toXml();
    }
}