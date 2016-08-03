<?php

namespace seregazhuk\tests;

use Mockery;
use seregazhuk\SmsIntel\XMLFormatter;
use seregazhuk\SmsIntel\Requests\XMLRequest;
use seregazhuk\SmsIntel\Contracts\HttpInterface;

class XMLRequestTest extends RequestTest
{
    /** @test */
    public function it_cancels_message()
    {
        $smsId = 1;

         $this
             ->createRequestMock('cancel', ['smsid' => $smsId])
             ->cancel($smsId);
    }

    /** @test */
    public function it_returns_balance()
    {
        $this->createRequestMock('balance')
            ->getBalance();
    }

    /** @test */
    public function it_returns_report_by_phone_number()
    {
        $phone = 1234567;
        $dateFrom = '2016-01-01';
        $dateTo =  '2016-01-01';

        $this
            ->createRequestMock('reportNumber',
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
            ->createRequestMock('report', ['smsid' => $smsId])
            ->getReportBySms($smsId);

    }

    /** @test */
    public function it_returns_report_by_source()
    {
        $source = 'FromPHP';
        $dateFrom = '2016-01-01';
        $dateTo =  '2016-01-01';

        $this
            ->createRequestMock('report',
                [
                    'start' => $dateFrom,
                    'stop' => $dateTo,
                    'source' => $source
                ])
            ->getReport($dateFrom, $dateTo, $source);
    }

    /**
     * @param string $action
     * @param array $requestParams
     * @return XMLRequest
     */
    protected function createRequestMock($action, $requestParams = [])
    {
        $httpClient = $this->getHttpMock();
        $requestParams = $this->appendCredentialsToRequestParams($requestParams);

        $request = (new XMLRequest($httpClient))
            ->setCredentials('test', 'test');

        $httpClient
            ->shouldReceive('post')
            ->with(
                $request->makeEndPoint($action),
                (new XMLFormatter($requestParams))->toXml()
            )
            ->andReturn('<?xml version=\'1.0\' encoding=\'UTF-8\'?><data></data>');

        return $request;

    }
}
