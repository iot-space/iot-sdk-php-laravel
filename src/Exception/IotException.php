<?php

namespace IotSpace\Exception;

use Exception;
use RuntimeException;

class IotException extends Exception
{

    /**
     * @var string
     */
    protected $errorCode;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * @var mixed
     */
    protected $errorData;

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @codeCoverageIgnore
     * @deprecated
     */
    public function setErrorCode()
    {
        throw new RuntimeException('deprecated since 2.0.');
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param $errorMessage
     *
     * @deprecated
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return mixed
     */
    public function getErrorData()
    {
        return $this->errorData;
    }

    /**
     * @param $errorData
     */
    public function setErrorData($errorData)
    {
        $this->errorData = $errorData;
    }

    public function __construct($errorMessage, $errorCode='', $errorData = null, $previous = null)
    {
        parent::__construct($errorMessage, 0, $previous);
        $this->errorMessage = $errorMessage;
        $this->errorCode    = $errorCode;
        $this->errorData    = $errorData;
    }

}
