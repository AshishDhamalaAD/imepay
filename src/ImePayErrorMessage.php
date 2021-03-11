<?php

namespace Asdh\ImePay;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ImePayErrorMessage
{
    public const UNAUTHORIZED = 'Unauthorized. Please make sure that all the credentials are correct.';
    public const INTERNAL_SERVER_ERROR = '500: IME Pay Internal Server Error.';

    private $exception;

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }

    public function get(): string
    {
        switch ($this->exception->getCode()) {
            case Response::HTTP_UNAUTHORIZED:
                return self::UNAUTHORIZED;
            case Response::HTTP_INTERNAL_SERVER_ERROR:
                return self::INTERNAL_SERVER_ERROR;
            default:
                return $this->exception->getMessage();
        }
    }
}
