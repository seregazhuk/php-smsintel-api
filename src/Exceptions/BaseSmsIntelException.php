<?php

namespace seregazhuk\SmsIntel\Exceptions;

use Throwable;

class BaseSmsIntelException extends \Exception
{
    /** @var array */
    protected $errorDescr;

    public function __construct($message = "", $code = 0, array $errorDescr = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errorDescr = $errorDescr;
    }
}
