<?php

namespace Asdh\ImePay;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ImePayErrorMessage
{
    public const UNAUTHORIZED = 'Unauthorized. Please make sure that all the credentials are correct.';

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
            default:
                return $this->exception->getMessage();
        }
    }
}
