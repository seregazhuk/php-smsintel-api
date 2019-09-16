<?php

namespace seregazhuk\SmsIntel\Exceptions;

use Throwable;

class BaseSmsIntelException extends \Exception
{
    /** @var array */
    protected $errorData;

    public function __construct($message = "", $code = 0, array $errorData = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errorData = $errorData;
    }

    /**
     * @return array|null
     */
    public function getErrorData()
    {
        return $this->errorData;
    }
}
