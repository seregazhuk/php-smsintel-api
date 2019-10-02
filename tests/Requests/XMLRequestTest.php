<?php

namespace seregazhuk\tests\Requests;

use Mockery;
use seregazhuk\SmsIntel\Formatters\XMLFormatter;
use seregazhuk\SmsIntel\Api\Requests\XMLRequest;

class XMLRequestTest extends RequestTest
{
    protected $requestClass = XMLRequest::class;

    /** @test */
    public function it_cancels_message()
    {
        $smsId = 1;
        $this
             ->getRequestMock('cancel', ['smsid' => $smsId])
             ->cancel($smsId);
    }

    /** @test */
    public function it_returns_balance()
    {
        $this->getRequestMock('balance')
            ->getBalance();
    }

    /** @test */
    public function it_returns_report_by_phone_number()
    {
        $phone = 1234567;
        $dateFrom = '2016-01-01';
        $dateTo =  '2016-01-01';

        $this
            ->getRequestMock('reportNumber',
                [
                    'start' => $dateFrom,
                    'stop' => $dateTo,
                    'number' => $phone
                ])
            ->getReportByNumber($dateFrom, $dateTo, $phone);
    }

    /** @test */
    public function it_returns_report_by_sms()
    {
        $smsId = 1;
        $this
            ->getRequestMock('report', ['smsid' => $smsId])
            ->getReportBySms($smsId);

    }

    /** @test */
    public function it_checks_coupon()
    {
        $code = 'coupond';
        $markAsUsed = 1;
        $phone = '79999999999';

        $this->getRequestMock(
                'checkcode',
                [
                    'code'       => $code,
                    'markAsUsed' => (int)$markAsUsed,
                    'phone'      => $phone,
                ]
            )->checkCoupon($code, $markAsUsed, $phone);

    }

    /** @test */
    public function it_returns_report_by_source()
    {
        $source = 'FromPHP';
        $dateFrom = '2016-01-01';
        $dateTo =  '2016-01-01';

        $this
            ->getRequestMock('report',
                [
                    'start' => $dateFrom,
                    'stop' => $dateTo,
                    'source' => $source
                ])
            ->getReportBySource($dateFrom, $dateTo, $source);
    }

    /**
     * @param string $requestEndpoint
     * @param array $requestParams
     */
    protected function setHttpClientMockExpectations($requestEndpoint, $requestParams)
    {
        $this->httpClient
            ->shouldReceive('post')
            ->with(
                Mockery::on(function($endpoint) use ($requestEndpoint) {
                    return strpos($endpoint, $requestEndpoint) !== false;
                }),
                ['body' => (new XMLFormatter($requestParams))->toXml()]
            )
            ->andReturn('<?xml version=\'1.0\' encoding=\'UTF-8\'?><data></data>');

    }
}
