<?php

namespace Asdh\ImePay;

class ImePay
{
    public function getToken(string $refId, $amount): ImePayTokenResponse
    {
        return (new ImePayToken($refId, $amount))->get();
    }
}
