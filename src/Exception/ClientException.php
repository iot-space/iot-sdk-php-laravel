<?php

namespace IotSpace\Exception;


class ClientException extends IotException
{

    /**
     * ClientException constructor.
     * @param $errorMessage
     * @param string $errorCode
     * @param mixed $previous
     */
    public function __construct($errorMessage, $errorCode='', $previous = null)
    {
        parent::__construct($errorMessage, 0, $previous);
        $this->errorMessage = $errorMessage;
        $this->errorCode    = $errorCode;
    }

    /**
     * @codeCoverageIgnore
     * @deprecated
     */
    public function getErrorType()
    {
        return 'Client';
    }
}
