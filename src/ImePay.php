<?php

namespace Asdh\ImePay;

use Asdh\ImePay\Token\ImePayToken;
use Asdh\ImePay\Token\ImePayTokenResponse;
use Asdh\ImePay\Verification\ImePayVerify;
use Asdh\ImePay\Verification\ImePayVerifyRequestData;
use Asdh\ImePay\Verification\ImePayVerifyResponse;

class ImePay
{
    public function getToken(string $refId, $amount): ImePayTokenResponse
    {
        return (new ImePayToken($refId, $amount))->get();
    }

    public function verify(array $data): ImePayVerifyResponse
    {
        return (new ImePayVerify(new ImePayVerifyRequestData($data)))->verify();
    }
}
