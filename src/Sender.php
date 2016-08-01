<?php

namespace seregazhuk\SmsIntel;

use seregazhuk\SmsIntel\Exceptions\AuthException;
use seregazhuk\SmsIntel\Adapters\GuzzleHttpAdapter;

class Sender
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param $login
     * @param $password
     * @return static
     */
    public static function create($login, $password)
    {
        self::checkCredentials($login, $password);

        return new static($login, $password);
    }

    /**
     * @param string $login
     * @param string $password
     * @throws AuthException
     */
    protected static function checkCredentials($login, $password)
    {
        if(empty($login) || empty($password)) {
            throw new AuthException('You must provide login and password to send messages!');
        }
    }

    /**
     * @param string $login
     * @param string $password
     */
    private function __construct($login, $password)
    {
        $this->request = new Request(
            new GuzzleHttpAdapter(), $login, $password
        );
    }

    /**
     * @param string|array $to
     * @param string $from
     * @param string $message
     * @param array $params
     * @return array|null
     */
    public function send($to, $from, $message, $params = [])
    {
        $to = is_array($to) ? $to : [$to];

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
        return $this->request->exec('cancel', ['smsid' => $smsId]);
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
    public function getSmsReport($smsId)
    {
        return $this->request->exec('report', ['smsid' => $smsId]);
    }

    /**
     * @return array|null
     */
    public function getBalance()
    {
        return $this->request->exec('balance');
    }
}