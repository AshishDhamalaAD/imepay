<?php

namespace Asdh\ImePay;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Asdh\ImePay\ImePay
 */
class ImePayFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'imepay';
    }
}
