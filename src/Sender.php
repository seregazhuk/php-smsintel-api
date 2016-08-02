<?php

namespace seregazhuk\SmsIntel;

use seregazhuk\SmsIntel\Contracts\RequestInterface;

class Sender
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @param string|array $to
     * @param string $from
     * @param string $message
     * @param array $params
     * @return array|null
     */
    public function send($to, $from, $message, $params = [ ])
    {
        $to = is_array($to) ? $to : [ $to ];

        $requestParams = array_merge(
            [
                'to'     => $to,
                'text'   => $message,
                'source' => $from,
            ], $params
        );

        return $this->request->exec('send', $requestParams);
    }

    /**
     * @param string $smsId
     * @return array|null
     */
    public function cancel($smsId)
    {
        return $this->request->exec('cancel', [ 'smsid' => $smsId ]);
    }

    /**
     * @param string $coupon
     * @param bool $markAsUsed
     * @param null|string $phone
     * @return array|null
     */
    public function checkCoupon($coupon, $markAsUsed = true, $phone = null)
    {
        return $this->request->exec(
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
    public function getReport($dateFrom, $dateTo, $source = null)
    {
        return $this->request->exec(
            'report', [
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
        return $this->request->exec('report', [ 'smsid' => $smsId ]);
    }

    /**
     * @param string $dateFrom
     * @param string $dateTo
     * @param null|string $number
     * @return array|null
     */
    public function getReportByNumber($dateFrom, $dateTo, $number = null)
    {
        return $this->request->exec('reportNumber',
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
        return $this->request->exec('balance');
    }
}