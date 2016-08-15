<?php

namespace seregazhuk\SmsIntel\Api\Requests;

use seregazhuk\SmsIntel\Formatters\XMLFormatter;

class XMLRequest extends Request
{
    /**
     * @var array
     */
    public static $allowedMethods = [
        'cancel',
        'getBalance',
        'checkCoupon',
        'getReportBySms',
        'getReportBySource',
        'getReportByNumber',
    ];

    /**
     * @param string $smsId
     * @return array|null
     */
    public function cancel($smsId)
    {
        return $this->exec('cancel', [ 'smsid' => $smsId ]);
    }

    /**
     * @param string $coupon
     * @param bool $markAsUsed
     * @param null|string $phone
     * @return array|null
     */
    public function checkCoupon($coupon, $markAsUsed = true, $phone = null)
    {
        return $this->exec(
            'checkcode',
            [
                'code'       => $coupon,
                'markAsUsed' => (int)$markAsUsed,
                'phone'      => $phone,
            ]
        );
    }

    /**
     * @param string $dateFrom
     * @param string $dateTo
     * @param null|string $source
     * @return array|null
     */
    public function getReportBySource($dateFrom, $dateTo, $source = null)
    {
        return $this->exec(
            'report',
            [
                'start'  => $dateFrom,
                'stop'   => $dateTo,
                'source' => $source,
            ]
        );
    }

    /**
     * @param string $smsId
     * @return array|null
     */
    public function getReportBySms($smsId)
    {
        return $this->exec('report', [ 'smsid' => $smsId ]);
    }

    /**
     * @param string $dateFrom
     * @param string $dateTo
     * @param null|string $number
     * @return array|null
     */
    public function getReportByNumber($dateFrom, $dateTo, $number = null)
    {
        return $this->exec('reportNumber',
            [
                'start'  => $dateFrom,
                'stop'   => $dateTo,
                'number' => $number,
            ]);
    }

    /**
     * @return array|null
     */
    public function getBalance()
    {
        return $this->exec('balance');
    }

    /**
     * @param string $action
     * @return string
     */
    protected function makeEndPoint($action)
    {
        return 'https://lcab.smsintel.ru/API/XML/' . $action . '.php';
    }

    /**
     * @param array $requestBody
     * @return mixed
     */
    protected function formatRequestBody(array $requestBody)
    {
        return (new XMLFormatter($requestBody))->toXml();
    }

    /**
     * Parses XML from response and returns it as an array
     *
     * @param string $response
     * @return array
     */
    protected function parseResponse($response)
    {
        $xml = simplexml_load_string($response);
        return (array)$xml->children();
    }
}